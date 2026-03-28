<?php
/**
 * Front Controller / Router
 * placement_m/public/index.php
 *
 * URL pattern: index.php?page=xxx  (views)
 *              index.php?action=xxx (controller actions)
 */

// ---- Bootstrap ----
session_start();
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/app/controllers/AdminController.php';
require_once dirname(__DIR__) . '/app/controllers/StudentController.php';
require_once dirname(__DIR__) . '/app/models/Company.php';
require_once dirname(__DIR__) . '/app/models/Student.php';

$page   = $_GET['page']   ?? 'home';
$action = $_GET['action'] ?? '';

$admin   = new AdminController();
$student = new StudentController();

// ================================================================
// ACTIONS (POST/GET mutations → redirect)
// ================================================================
if ($action) {
    switch ($action) {
        // Admin auth
        case 'admin_login':    $admin->processLogin();  break;
        case 'admin_logout':   $admin->logout();        break;

        // Admin operations
        case 'approve_student':  $admin->approveStudent();   break;
        case 'delete_student':   $admin->deleteStudent();    break;
        case 'add_company':      $admin->addCompany();       break;
        case 'edit_company':     $admin->editCompany();      break;
        case 'delete_company':   $admin->deleteCompany();    break;
        case 'add_drive':        $admin->addDrive();         break;
        case 'edit_drive':       $admin->editDrive();        break;
        case 'delete_drive':     $admin->deleteDrive();      break;
        case 'update_application': $admin->updateApplication(); break;
        case 'add_notice':       $admin->addNotice();        break;
        case 'delete_notice':    $admin->deleteNotice();     break;

        // Student auth
        case 'student_login':    $student->processLogin();   break;
        case 'student_logout':   $student->logout();         break;
        case 'student_register': $student->processRegister(); break;

        // Student operations
        case 'upload_resume':  $student->uploadResume();    break;
        case 'apply':          $student->processApply();    break;

        default:
            header('Location: ' . BASE_URL . 'index.php?page=home');
            exit;
    }
    exit; // actions should always redirect; this is a safety net
}

// ================================================================
// VIEWS (render pages)
// ================================================================
switch ($page) {
    // ---- PUBLIC ----
    case 'home': {
        require_once dirname(__DIR__) . '/app/models/Admin.php';
        require_once dirname(__DIR__) . '/app/models/Student.php';
        $companyModel = new Company();
        $studentModel = new Student();
        $companies    = $companyModel->getAll();
        $drives       = $studentModel->getAllDrives();
        $notices      = (new Admin())->getAllNotices();
        $stats        = $companyModel->getPublicStats();
        require dirname(__DIR__) . '/app/views/public/home.php';
        break;
    }
    case 'about': {
        $stats = (new Company())->getPublicStats();
        require dirname(__DIR__) . '/app/views/public/about.php';
        break;
    }
    case 'companies': {
        $companies = (new Company())->getAll();
        require dirname(__DIR__) . '/app/views/public/companies.php';
        break;
    }
    case 'register':
        $student->showRegister();
        break;

    // ---- ADMIN PANEL ----
    case 'admin_dashboard':  $admin->dashboard();    break;
    case 'admin_students':   $admin->students();     break;
    case 'admin_companies':  $admin->companies();    break;
    case 'admin_applications': $admin->applications(); break;
    case 'admin_notices':    $admin->notices();      break;

    // ---- STUDENT PANEL ----
    case 'student_dashboard':    $student->dashboard();        break;
    case 'student_apply':        $student->applyPage();        break;
    case 'student_applications': $student->myApplications();   break;

    // ---- 404 ----
    default:
        http_response_code(404);
        echo '<!DOCTYPE html><html><head><title>404</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></head>
        <body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        <div class="text-center">
            <h1 class="display-1 text-muted">404</h1>
            <h3>Page Not Found</h3>
            <a href="' . BASE_URL . 'index.php?page=home" class="btn btn-primary mt-3">Go Home</a>
        </div></body></html>';
        break;
}
