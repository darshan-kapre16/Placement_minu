<?php
/**
 * Admin Model
 * placement_m/app/models/Admin.php
 */

require_once dirname(__DIR__, 2) . '/config/database.php';

class Admin {

    private mysqli $db;

    public function __construct() {
        $this->db = getDB();
    }

    /** Authenticate admin by username & password */
    public function login(string $username, string $password): array|false {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result && password_verify($password, $result['password'])) {
            return $result;
        }
        return false;
    }

    /** Dashboard statistics */
    public function getStats(): array {
        $stats = [];

        $queries = [
            'total_students'   => "SELECT COUNT(*) FROM students",
            'approved_students'=> "SELECT COUNT(*) FROM students WHERE approved = 1",
            'placed_students'  => "SELECT COUNT(*) FROM students WHERE placed = 1",
            'total_companies'  => "SELECT COUNT(*) FROM companies",
            'total_drives'     => "SELECT COUNT(*) FROM drives",
            'upcoming_drives'  => "SELECT COUNT(*) FROM drives WHERE status = 'upcoming'",
            'total_apps'       => "SELECT COUNT(*) FROM applications",
            'pending_apps'     => "SELECT COUNT(*) FROM applications WHERE status = 'pending'",
        ];

        foreach ($queries as $key => $sql) {
            $res = $this->db->query($sql);
            $stats[$key] = (int) $res->fetch_row()[0];
        }
        return $stats;
    }

    /** Get all students with optional search */
    public function getAllStudents(string $search = ''): array {
        if ($search) {
            $like = "%$search%";
            $stmt = $this->db->prepare(
                "SELECT * FROM students WHERE name LIKE ? OR email LIKE ? OR branch LIKE ? ORDER BY created_at DESC"
            );
            $stmt->bind_param("sss", $like, $like, $like);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM students ORDER BY created_at DESC");
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Approve or unapprove a student */
    public function setStudentApproval(int $id, int $approved): bool {
        $stmt = $this->db->prepare("UPDATE students SET approved = ? WHERE id = ?");
        $stmt->bind_param("ii", $approved, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /** Mark student as placed/not placed */
    public function setStudentPlaced(int $id, int $placed): bool {
        $stmt = $this->db->prepare("UPDATE students SET placed = ? WHERE id = ?");
        $stmt->bind_param("ii", $placed, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /** Delete a student */
    public function deleteStudent(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /** Get single student */
    public function getStudentById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ---- APPLICATIONS ----

    /** Get all applications with student + company details */
    public function getAllApplications(string $filter = ''): array {
        $sql = "SELECT a.*, s.name AS student_name, s.email, s.branch, s.cgpa, s.resume,
                       c.company_name, c.package
                FROM applications a
                JOIN students s ON a.student_id = s.id
                JOIN companies c ON a.company_id = c.id";
        if ($filter && in_array($filter, ['pending','accepted','rejected'])) {
            $stmt = $this->db->prepare($sql . " WHERE a.status = ? ORDER BY a.applied_at DESC");
            $stmt->bind_param("s", $filter);
        } else {
            $stmt = $this->db->prepare($sql . " ORDER BY a.applied_at DESC");
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Update application status */
    public function updateApplicationStatus(int $appId, string $status): bool {
        if (!in_array($status, ['pending','accepted','rejected'])) return false;

        $stmt = $this->db->prepare("UPDATE applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $appId);
        $result = $stmt->execute();
        $stmt->close();

        // If accepted, mark student as placed
        if ($status === 'accepted') {
            $stmt2 = $this->db->prepare(
                "UPDATE students SET placed = 1 WHERE id = (SELECT student_id FROM applications WHERE id = ?)"
            );
            $stmt2->bind_param("i", $appId);
            $stmt2->execute();
            $stmt2->close();
        }
        return $result;
    }

    // ---- NOTICES ----

    public function getAllNotices(): array {
        return $this->db->query("SELECT * FROM notices ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
    }

    public function addNotice(string $title, string $content, string $file = ''): bool {
        $stmt = $this->db->prepare("INSERT INTO notices (title, content, file) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $file);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteNotice(int $id): array {
        // Get file before deleting
        $stmt = $this->db->prepare("SELECT file FROM notices WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $stmt2 = $this->db->prepare("DELETE FROM notices WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        return $row ?? [];
    }
}
