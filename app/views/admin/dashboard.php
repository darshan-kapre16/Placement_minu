<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="admin-layout">
<?php require __DIR__ . '/sidebar.php'; ?>
<div class="main-content">
    <div class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <h1 class="page-title">Dashboard</h1>
        <div class="topbar-right">
            <span class="text-muted small">Welcome, <strong><?= htmlspecialchars($_SESSION['admin_user']) ?></strong></span>
        </div>
    </div>

    <div class="content-body">
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-blue">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number"><?= $stats['total_students'] ?></div>
                        <div class="stat-label">Total Students</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-green">
                    <div class="stat-icon"><i class="bi bi-building-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number"><?= $stats['total_companies'] ?></div>
                        <div class="stat-label">Companies</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-purple">
                    <div class="stat-icon"><i class="bi bi-trophy-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number"><?= $stats['placed_students'] ?></div>
                        <div class="stat-label">Placed Students</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-orange">
                    <div class="stat-icon"><i class="bi bi-calendar-event-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number"><?= $stats['upcoming_drives'] ?></div>
                        <div class="stat-label">Upcoming Drives</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Stats -->
        <div class="row g-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-teal">
                    <div class="stat-icon"><i class="bi bi-person-check-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number"><?= $stats['approved_students'] ?></div>
                        <div class="stat-label">Approved Students</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-red">
                    <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                    <div class="stat-info">
                        <div class="stat-number"><?= $stats['pending_apps'] ?></div>
                        <div class="stat-label">Pending Applications</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-indigo">
                    <div class="stat-icon"><i class="bi bi-file-earmark-check-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number"><?= $stats['total_apps'] ?></div>
                        <div class="stat-label">Total Applications</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card stat-pink">
                    <div class="stat-icon"><i class="bi bi-calendar-check-fill"></i></div>
                    <div class="stat-info">
                        <div class="stat-number"><?= $stats['total_drives'] ?></div>
                        <div class="stat-label">Total Drives</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Upcoming Drives -->
            <div class="col-lg-7">
                <div class="card admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-calendar-event me-2 text-primary"></i>Upcoming Drives</h5>
                        <a href="index.php?page=admin_companies" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($drives)): ?>
                            <div class="empty-state py-4">
                                <i class="bi bi-calendar-x"></i><p>No drives scheduled yet.</p>
                            </div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead><tr><th>Company</th><th>Date</th><th>Status</th></tr></thead>
                                <tbody>
                                <?php foreach (array_slice($drives, 0, 6) as $d): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($d['company_name']) ?></td>
                                        <td><?= date('d M Y', strtotime($d['drive_date'])) ?></td>
                                        <td><span class="badge bg-<?= $d['status'] === 'upcoming' ? 'success' : ($d['status'] === 'ongoing' ? 'warning' : 'secondary') ?>">
                                            <?= ucfirst($d['status']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Notices -->
            <div class="col-lg-5">
                <div class="card admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-bell me-2 text-warning"></i>Recent Notices</h5>
                        <a href="index.php?page=admin_notices" class="btn btn-sm btn-outline-warning">Manage</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($notices)): ?>
                            <div class="empty-state py-3"><i class="bi bi-bell-slash"></i><p>No notices yet.</p></div>
                        <?php else: ?>
                            <?php foreach (array_slice($notices, 0, 5) as $n): ?>
                                <div class="notice-item">
                                    <div class="notice-dot"></div>
                                    <div>
                                        <div class="notice-title"><?= htmlspecialchars($n['title']) ?></div>
                                        <div class="notice-date"><?= date('d M Y', strtotime($n['created_at'])) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /content-body -->
</div><!-- /main-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/admin.js"></script>
</body>
</html>
