<?php
/**
 * Company Model
 * placement_m/app/models/Company.php
 */

require_once dirname(__DIR__, 2) . '/config/database.php';

class Company {

    private mysqli $db;

    public function __construct() {
        $this->db = getDB();
    }

    public function getAll(): array {
        return $this->db->query("SELECT * FROM companies ORDER BY company_name")->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM companies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function add(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO companies (company_name, location, package, description, website) VALUES (?,?,?,?,?)"
        );
        $stmt->bind_param("sssss", $data['company_name'], $data['location'], $data['package'], $data['description'], $data['website']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE companies SET company_name=?, location=?, package=?, description=?, website=? WHERE id=?"
        );
        $stmt->bind_param("sssssi", $data['company_name'], $data['location'], $data['package'], $data['description'], $data['website'], $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM companies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // ---- DRIVES ----

    public function getAllDrives(): array {
        return $this->db->query(
            "SELECT d.*, c.company_name FROM drives d JOIN companies c ON d.company_id = c.id ORDER BY d.drive_date DESC"
        )->fetch_all(MYSQLI_ASSOC);
    }

    public function getDriveById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT d.*, c.company_name FROM drives d JOIN companies c ON d.company_id = c.id WHERE d.id=?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addDrive(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO drives (company_id, drive_date, eligibility, status, description) VALUES (?,?,?,?,?)"
        );
        $stmt->bind_param("issss", $data['company_id'], $data['drive_date'], $data['eligibility'], $data['status'], $data['description']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateDrive(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE drives SET company_id=?, drive_date=?, eligibility=?, status=?, description=? WHERE id=?"
        );
        $stmt->bind_param("issssi", $data['company_id'], $data['drive_date'], $data['eligibility'], $data['status'], $data['description'], $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteDrive(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM drives WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /** Stats for public page */
    public function getPublicStats(): array {
        $stats = [];
        $stats['companies'] = (int) $this->db->query("SELECT COUNT(*) FROM companies")->fetch_row()[0];
        $stats['drives']    = (int) $this->db->query("SELECT COUNT(*) FROM drives")->fetch_row()[0];
        $stats['placed']    = (int) $this->db->query("SELECT COUNT(*) FROM students WHERE placed=1")->fetch_row()[0];
        $stats['students']  = (int) $this->db->query("SELECT COUNT(*) FROM students WHERE approved=1")->fetch_row()[0];
        return $stats;
    }
}
