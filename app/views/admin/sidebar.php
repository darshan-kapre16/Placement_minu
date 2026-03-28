<?php
/**
 * Admin Sidebar
 * placement_m/app/views/admin/sidebar.php
 */
$currentPage = $_GET['page'] ?? '';
?>
<nav class="sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <div class="brand-text">
            <span class="brand-title">Placement Cell</span>
            <span class="brand-sub">Admin Portal</span>
        </div>
    </div>

    <div class="sidebar-admin-info">
        <div class="admin-avatar"><i class="bi bi-person-circle"></i></div>
        <div>
            <div class="admin-name"><?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin') ?></div>
            <div class="admin-role">Administrator</div>
        </div>
    </div>

    <ul class="sidebar-menu">
        <li class="menu-label">MAIN MENU</li>
        <li class="<?= $currentPage === 'admin_dashboard' ? 'active' : '' ?>">
            <a href="index.php?page=admin_dashboard">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </li>
        <li class="menu-label">MANAGEMENT</li>
        <li class="<?= $currentPage === 'admin_students' ? 'active' : '' ?>">
            <a href="index.php?page=admin_students">
                <i class="bi bi-people-fill"></i> Students
            </a>
        </li>
        <li class="<?= $currentPage === 'admin_companies' ? 'active' : '' ?>">
            <a href="index.php?page=admin_companies">
                <i class="bi bi-building-fill"></i> Companies & Drives
            </a>
        </li>
        <li class="<?= $currentPage === 'admin_applications' ? 'active' : '' ?>">
            <a href="index.php?page=admin_applications">
                <i class="bi bi-file-earmark-text-fill"></i> Applications
            </a>
        </li>
        <li class="<?= $currentPage === 'admin_notices' ? 'active' : '' ?>">
            <a href="index.php?page=admin_notices">
                <i class="bi bi-bell-fill"></i> Notices
            </a>
        </li>
        <li class="menu-label">ACCOUNT</li>
        <li>
            <a href="index.php?action=admin_logout" class="logout-link">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="index.php?page=home" target="_blank"><i class="bi bi-globe"></i> View Public Site</a>
    </div>
</nav>
