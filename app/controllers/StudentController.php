<?php
/**
 * Student Controller
 * placement_m/app/controllers/StudentController.php
 */

require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__) . '/models/Student.php';

class StudentController {

    private Student $studentModel;

    public function __construct() {
        $this->studentModel = new Student();
    }

    /** Ensure only logged-in students can proceed */
    private function requireStudent(): void {
        if (empty($_SESSION['student_id'])) {
            header('Location: ' . BASE_URL . 'login.php');
            exit;
        }
    }

    // ============================================================
    // AUTH
    // ============================================================

    public function showLogin(): void {
        $error = $_SESSION['student_login_error'] ?? '';
        unset($_SESSION['student_login_error']);
        require dirname(__DIR__) . '/views/student/login.php';
    }

    public function processLogin(): void {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $student = $this->studentModel->login($email, $password);
        if ($student) {
            session_regenerate_id(true);
            $_SESSION['student_id']   = $student['id'];
            $_SESSION['student_name'] = $student['name'];
            header('Location: ' . BASE_URL . 'index.php?page=student_dashboard');
        } else {
            $_SESSION['student_login_error'] = 'Invalid email or password.';
            header('Location: ' . BASE_URL . 'login.php');
        }
        exit;
    }

    public function showRegister(): void {
        $error = $_SESSION['register_error'] ?? '';
        unset($_SESSION['register_error']);
        require dirname(__DIR__) . '/views/student/register.php';
    }

    public function processRegister(): void {
        $data = [
            'name'     => trim($_POST['name'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'phone'    => trim($_POST['phone'] ?? ''),
            'branch'   => trim($_POST['branch'] ?? ''),
            'year'     => trim($_POST['year'] ?? ''),
            'cgpa'     => (float) ($_POST['cgpa'] ?? 0),
        ];

        if (!$data['name'] || !$data['email'] || !$data['password']) {
            $_SESSION['register_error'] = 'Name, email and password are required.';
            header('Location: ' . BASE_URL . 'login.php?view=register');
            exit;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = 'Invalid email address.';
            header('Location: ' . BASE_URL . 'login.php?view=register');
            exit;
        }

        $result = $this->studentModel->register($data);
        if ($result['success']) {
            $_SESSION['register_success'] = 'Registration successful! Please login.';
            header('Location: ' . BASE_URL . 'login.php');
        } else {
            $_SESSION['register_error'] = $result['message'];
            header('Location: ' . BASE_URL . 'login.php?view=register');
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
        $this->requireStudent();
        $id      = (int) $_SESSION['student_id'];
        $student = $this->studentModel->getById($id);
        $drives  = $this->studentModel->getUpcomingDrives();
        $notices = $this->studentModel->getNotices();
        $apps    = $this->studentModel->getApplications($id);
        require dirname(__DIR__) . '/views/student/dashboard.php';
    }

    // ============================================================
    // RESUME UPLOAD
    // ============================================================

    public function uploadResume(): void {
        $this->requireStudent();
        $id = (int) $_SESSION['student_id'];

        if (empty($_FILES['resume']['name'])) {
            header('Location: ' . BASE_URL . 'index.php?page=student_dashboard&msg=no_file');
            exit;
        }

        $ext     = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx'];
        if (!in_array($ext, $allowed)) {
            header('Location: ' . BASE_URL . 'index.php?page=student_dashboard&msg=invalid_file');
            exit;
        }

        if ($_FILES['resume']['size'] > 2 * 1024 * 1024) { // 2MB max
            header('Location: ' . BASE_URL . 'index.php?page=student_dashboard&msg=file_too_large');
            exit;
        }

        // Delete old resume
        $student = $this->studentModel->getById($id);
        if (!empty($student['resume'])) {
            @unlink(UPLOAD_PATH . $student['resume']);
        }

        $filename = 'resume_' . $id . '_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES['resume']['tmp_name'], UPLOAD_PATH . $filename)) {
            $this->studentModel->updateResume($id, $filename);
            $_SESSION['student_name'] = $student['name']; // refresh
        }

        header('Location: ' . BASE_URL . 'index.php?page=student_dashboard&msg=resume_uploaded');
        exit;
    }

    // ============================================================
    // APPLY
    // ============================================================

    public function applyPage(): void {
        $this->requireStudent();
        $id      = (int) $_SESSION['student_id'];
        $student = $this->studentModel->getById($id);
        $drives  = $this->studentModel->getUpcomingDrives();
        $apps    = $this->studentModel->getApplications($id);
        // Build applied company IDs
        $appliedCompanies = array_column($apps, 'company_id');
        require dirname(__DIR__) . '/views/student/apply.php';
    }

    public function processApply(): void {
        $this->requireStudent();
        $studentId = (int) $_SESSION['student_id'];
        $companyId = (int) ($_POST['company_id'] ?? 0);
        $driveId   = (int) ($_POST['drive_id'] ?? 0) ?: null;

        // Check student is approved & has resume
        $student = $this->studentModel->getById($studentId);
        if (!$student['approved']) {
            header('Location: ' . BASE_URL . 'index.php?page=student_apply&msg=not_approved');
            exit;
        }
        if (empty($student['resume'])) {
            header('Location: ' . BASE_URL . 'index.php?page=student_apply&msg=no_resume');
            exit;
        }

        $result = $this->studentModel->apply($studentId, $companyId, $driveId);
        $msg    = $result['success'] ? 'applied' : 'already_applied';
        header('Location: ' . BASE_URL . 'index.php?page=student_apply&msg=' . $msg);
        exit;
    }

    // ============================================================
    // MY APPLICATIONS
    // ============================================================

    public function myApplications(): void {
        $this->requireStudent();
        $id       = (int) $_SESSION['student_id'];
        $student  = $this->studentModel->getById($id);
        $apps     = $this->studentModel->getApplications($id);
        require dirname(__DIR__) . '/views/student/applications.php';
    }
}
