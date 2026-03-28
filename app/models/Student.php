<?php
/**
 * Student Model
 * placement_m/app/models/Student.php
 */

require_once dirname(__DIR__, 2) . '/config/database.php';

class Student {

    private mysqli $db;

    public function __construct() {
        $this->db = getDB();
    }

    /** Register new student */
    public function register(array $data): array {
        // Check duplicate email
        $stmt = $this->db->prepare("SELECT id FROM students WHERE email = ?");
        $stmt->bind_param("s", $data['email']);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return ['success' => false, 'message' => 'Email already registered.'];
        }
        $stmt->close();

        $hash = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = $this->db->prepare(
            "INSERT INTO students (name, email, password, phone, branch, year, cgpa) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssssssd",
            $data['name'], $data['email'], $hash,
            $data['phone'], $data['branch'], $data['year'], $data['cgpa']
        );
        $result = $stmt->execute();
        $id = $this->db->insert_id;
        $stmt->close();

        return $result
            ? ['success' => true, 'id' => $id]
            : ['success' => false, 'message' => 'Registration failed. Try again.'];
    }

    /** Login student */
    public function login(string $email, string $password): array|false {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($row && password_verify($password, $row['password'])) {
            return $row;
        }
        return false;
    }

    /** Get student by ID */
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /** Update resume filename */
    public function updateResume(int $id, string $filename): bool {
        $stmt = $this->db->prepare("UPDATE students SET resume = ? WHERE id = ?");
        $stmt->bind_param("si", $filename, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /** Update student profile */
    public function updateProfile(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE students SET name=?, phone=?, branch=?, year=?, cgpa=? WHERE id=?"
        );
        $stmt->bind_param("ssssdis", $data['name'], $data['phone'], $data['branch'], $data['year'], $data['cgpa'], $id);
        // fix types
        $stmt->close();

        $stmt = $this->db->prepare(
            "UPDATE students SET name=?, phone=?, branch=?, year=?, cgpa=? WHERE id=?"
        );
        $stmt->bind_param("ssssdi", $data['name'], $data['phone'], $data['branch'], $data['year'], $data['cgpa'], $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // ---- COMPANIES & DRIVES ----

    /** Get all companies */
    public function getCompanies(): array {
        return $this->db->query("SELECT * FROM companies ORDER BY company_name")->fetch_all(MYSQLI_ASSOC);
    }

    /** Get upcoming drives with company info */
    public function getUpcomingDrives(): array {
        return $this->db->query(
            "SELECT d.*, c.company_name, c.package, c.location
             FROM drives d
             JOIN companies c ON d.company_id = c.id
             WHERE d.status IN ('upcoming','ongoing')
             ORDER BY d.drive_date ASC"
        )->fetch_all(MYSQLI_ASSOC);
    }

    /** Get all drives */
    public function getAllDrives(): array {
        return $this->db->query(
            "SELECT d.*, c.company_name, c.package, c.location
             FROM drives d JOIN companies c ON d.company_id = c.id
             ORDER BY d.drive_date DESC"
        )->fetch_all(MYSQLI_ASSOC);
    }

    // ---- APPLICATIONS ----

    /** Apply for a company */
    public function apply(int $studentId, int $companyId, ?int $driveId): array {
        // Check if already applied
        $stmt = $this->db->prepare("SELECT id FROM applications WHERE student_id=? AND company_id=?");
        $stmt->bind_param("ii", $studentId, $companyId);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return ['success' => false, 'message' => 'You have already applied to this company.'];
        }
        $stmt->close();

        $stmt = $this->db->prepare(
            "INSERT INTO applications (student_id, company_id, drive_id) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iii", $studentId, $companyId, $driveId);
        $result = $stmt->execute();
        $stmt->close();

        return $result
            ? ['success' => true, 'message' => 'Application submitted successfully!']
            : ['success' => false, 'message' => 'Application failed. Try again.'];
    }

    /** Get student's applications */
    public function getApplications(int $studentId): array {
        $stmt = $this->db->prepare(
            "SELECT a.*, c.company_name, c.package, c.location, d.drive_date, d.eligibility
             FROM applications a
             JOIN companies c ON a.company_id = c.id
             LEFT JOIN drives d ON a.drive_id = d.id
             WHERE a.student_id = ?
             ORDER BY a.applied_at DESC"
        );
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ---- NOTICES ----

    public function getNotices(): array {
        return $this->db->query("SELECT * FROM notices ORDER BY created_at DESC LIMIT 20")->fetch_all(MYSQLI_ASSOC);
    }
}
