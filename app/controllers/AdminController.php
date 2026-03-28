<?php
/**
 * Admin Controller
 * placement_m/app/controllers/AdminController.php
 */

require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__) . '/models/Admin.php';
require_once dirname(__DIR__) . '/models/Company.php';

class AdminController {

    private Admin $adminModel;
    private Company $companyModel;

    public function __construct() {
        $this->adminModel   = new Admin();
        $this->companyModel = new Company();
    }

    /** Ensure only logged-in admins can proceed */
    private function requireAdmin(): void {
        if (empty($_SESSION['admin_id'])) {
            header('Location: ' . BASE_URL . 'login.php');
            exit;
        }
    }

    // ============================================================
    // AUTH
    // ============================================================

    public function showLogin(): void {
        $error = $_SESSION['admin_login_error'] ?? '';
        unset($_SESSION['admin_login_error']);
        require dirname(__DIR__) . '/views/admin/login.php';
    }

    public function processLogin(): void {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$username || !$password) {
            $_SESSION['admin_login_error'] = 'Please fill in all fields.';
            header('Location: ' . BASE_URL . 'login.php');
            exit;
        }

        $admin = $this->adminModel->login($username, $password);
        if ($admin) {
            session_regenerate_id(true);
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_user'] = $admin['username'];
            header('Location: ' . BASE_URL . 'index.php?page=admin_dashboard');
        } else {
            $_SESSION['admin_login_error'] = 'Invalid username or password.';
            header('Location: ' . BASE_URL . 'login.php');
        }
        exit;
    }

    public function logout(): void {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }

    // ============================================================
    // DASHBOARD
    // ============================================================

    public function dashboard(): void {
        $this->requireAdmin();
        $stats    = $this->adminModel->getStats();
        $notices  = $this->adminModel->getAllNotices();
        $drives   = $this->companyModel->getAllDrives();
        require dirname(__DIR__) . '/views/admin/dashboard.php';
    }

    // ============================================================
    // STUDENTS
    // ============================================================

    public function students(): void {
        $this->requireAdmin();
        $search   = trim($_GET['search'] ?? '');
        $students = $this->adminModel->getAllStudents($search);
        require dirname(__DIR__) . '/views/admin/students.php';
    }

    public function approveStudent(): void {
        $this->requireAdmin();
        $id       = (int) ($_GET['id'] ?? 0);
        $approved = (int) ($_GET['approved'] ?? 0);
        $this->adminModel->setStudentApproval($id, $approved);
        header('Location: ' . BASE_URL . 'index.php?page=admin_students&msg=updated');
        exit;
    }

    public function deleteStudent(): void {
        $this->requireAdmin();
        $id = (int) ($_POST['id'] ?? 0);
        $this->adminModel->deleteStudent($id);
        header('Location: ' . BASE_URL . 'index.php?page=admin_students&msg=deleted');
        exit;
    }

    // ============================================================
    // COMPANIES
    // ============================================================

    public function companies(): void {
        $this->requireAdmin();
        $companies = $this->companyModel->getAll();
        $drives    = $this->companyModel->getAllDrives();
        $edit      = null;
        if (!empty($_GET['edit'])) {
            $edit = $this->companyModel->getById((int) $_GET['edit']);
        }
        $editDrive = null;
        if (!empty($_GET['edit_drive'])) {
            $editDrive = $this->companyModel->getDriveById((int) $_GET['edit_drive']);
        }
        require dirname(__DIR__) . '/views/admin/companies.php';
    }

    public function addCompany(): void {
        $this->requireAdmin();
        $data = [
            'company_name' => trim($_POST['company_name'] ?? ''),
            'location'     => trim($_POST['location'] ?? ''),
            'package'      => trim($_POST['package'] ?? ''),
            'description'  => trim($_POST['description'] ?? ''),
            'website'      => trim($_POST['website'] ?? ''),
        ];
        $this->companyModel->add($data);
        header('Location: ' . BASE_URL . 'index.php?page=admin_companies&msg=added');
        exit;
    }

    public function editCompany(): void {
        $this->requireAdmin();
        $id   = (int) ($_POST['id'] ?? 0);
        $data = [
            'company_name' => trim($_POST['company_name'] ?? ''),
            'location'     => trim($_POST['location'] ?? ''),
            'package'      => trim($_POST['package'] ?? ''),
            'description'  => trim($_POST['description'] ?? ''),
            'website'      => trim($_POST['website'] ?? ''),
        ];
        $this->companyModel->update($id, $data);
        header('Location: ' . BASE_URL . 'index.php?page=admin_companies&msg=updated');
        exit;
    }

    public function deleteCompany(): void {
        $this->requireAdmin();
        $id = (int) ($_POST['id'] ?? 0);
        $this->companyModel->delete($id);
        header('Location: ' . BASE_URL . 'index.php?page=admin_companies&msg=deleted');
        exit;
    }

    // ---- DRIVES ----

    public function addDrive(): void {
        $this->requireAdmin();
        $data = [
            'company_id'  => (int) ($_POST['company_id'] ?? 0),
            'drive_date'  => $_POST['drive_date'] ?? '',
            'eligibility' => trim($_POST['eligibility'] ?? ''),
            'status'      => $_POST['status'] ?? 'upcoming',
            'description' => trim($_POST['description'] ?? ''),
        ];
        $this->companyModel->addDrive($data);
        header('Location: ' . BASE_URL . 'index.php?page=admin_companies&msg=drive_added');
        exit;
    }

    public function editDrive(): void {
        $this->requireAdmin();
        $id   = (int) ($_POST['id'] ?? 0);
        $data = [
            'company_id'  => (int) ($_POST['company_id'] ?? 0),
            'drive_date'  => $_POST['drive_date'] ?? '',
            'eligibility' => trim($_POST['eligibility'] ?? ''),
            'status'      => $_POST['status'] ?? 'upcoming',
            'description' => trim($_POST['description'] ?? ''),
        ];
        $this->companyModel->updateDrive($id, $data);
        header('Location: ' . BASE_URL . 'index.php?page=admin_companies&msg=drive_updated');
        exit;
    }

    public function deleteDrive(): void {
        $this->requireAdmin();
        $id = (int) ($_POST['id'] ?? 0);
        $this->companyModel->deleteDrive($id);
        header('Location: ' . BASE_URL . 'index.php?page=admin_companies&msg=drive_deleted');
        exit;
    }

    // ============================================================
    // APPLICATIONS
    // ============================================================

    public function applications(): void {
        $this->requireAdmin();
        $filter       = $_GET['filter'] ?? '';
        $applications = $this->adminModel->getAllApplications($filter);
        require dirname(__DIR__) . '/views/admin/applications.php';
    }

    public function updateApplication(): void {
        $this->requireAdmin();
        $id     = (int) ($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? '';
        $this->adminModel->updateApplicationStatus($id, $status);
        header('Location: ' . BASE_URL . 'index.php?page=admin_applications&msg=updated');
        exit;
    }

    // ============================================================
    // NOTICES
    // ============================================================

    public function notices(): void {
        $this->requireAdmin();
        $notices = $this->adminModel->getAllNotices();
        require dirname(__DIR__) . '/views/admin/notices.php';
    }

    public function addNotice(): void {
        $this->requireAdmin();
        $title   = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $file    = '';

        // Handle file upload
        if (!empty($_FILES['file']['name'])) {
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'png'];
            $ext     = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $file = uniqid('notice_') . '.' . $ext;
                move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_PATH . '../notices/' . $file);
                @mkdir(UPLOAD_PATH . '../notices/', 0755, true);
                move_uploaded_file($_FILES['file']['tmp_name'], dirname(UPLOAD_PATH) . '/notices/' . $file);
            }
        }

        $this->adminModel->addNotice($title, $content, $file);
        header('Location: ' . BASE_URL . 'index.php?page=admin_notices&msg=added');
        exit;
    }

    public function deleteNotice(): void {
        $this->requireAdmin();
        $id  = (int) ($_POST['id'] ?? 0);
        $row = $this->adminModel->deleteNotice($id);
        // Optionally delete file
        if (!empty($row['file'])) {
            @unlink(dirname(UPLOAD_PATH) . '/notices/' . $row['file']);
        }
        header('Location: ' . BASE_URL . 'index.php?page=admin_notices&msg=deleted');
        exit;
    }
}
