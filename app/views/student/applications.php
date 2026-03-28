<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications | Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="student-layout">
<nav class="navbar student-navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=student_dashboard"><i class="bi bi-mortarboard-fill me-2"></i>Placement Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#stuNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="stuNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item"><a href="index.php?page=student_dashboard" class="nav-link"><i class="bi bi-grid me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a href="index.php?page=student_apply" class="nav-link"><i class="bi bi-send me-1"></i>Apply</a></li>
                <li class="nav-item"><a href="index.php?page=student_applications" class="nav-link active"><i class="bi bi-file-text me-1"></i>My Applications</a></li>
                <li class="nav-item"><a href="index.php?action=student_logout" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="student-content">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0"><i class="bi bi-file-earmark-text me-2 text-primary"></i>My Applications</h4>
        <span class="badge bg-primary fs-6"><?= count($apps) ?> Total</span>
    </div>

    <?php if (empty($apps)): ?>
        <div class="card student-card">
            <div class="empty-state py-5">
                <i class="bi bi-file-earmark-x"></i>
                <p>No applications yet.</p>
                <a href="index.php?page=student_apply" class="btn btn-primary"><i class="bi bi-send me-2"></i>Browse & Apply</a>
            </div>
        </div>
    <?php else: ?>
        <!-- Summary cards -->
        <div class="row g-3 mb-4">
            <?php
            $total    = count($apps);
            $pending  = count(array_filter($apps, fn($a) => $a['status']==='pending'));
            $accepted = count(array_filter($apps, fn($a) => $a['status']==='accepted'));
            $rejected = count(array_filter($apps, fn($a) => $a['status']==='rejected'));
            ?>
            <div class="col-6 col-md-3"><div class="stat-card stat-blue"><div class="stat-icon"><i class="bi bi-file-text-fill"></i></div><div class="stat-info"><div class="stat-number"><?= $total ?></div><div class="stat-label">Total</div></div></div></div>
            <div class="col-6 col-md-3"><div class="stat-card stat-orange"><div class="stat-icon"><i class="bi bi-hourglass-split"></i></div><div class="stat-info"><div class="stat-number"><?= $pending ?></div><div class="stat-label">Pending</div></div></div></div>
            <div class="col-6 col-md-3"><div class="stat-card stat-green"><div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div><div class="stat-info"><div class="stat-number"><?= $accepted ?></div><div class="stat-label">Accepted</div></div></div></div>
            <div class="col-6 col-md-3"><div class="stat-card stat-red"><div class="stat-icon"><i class="bi bi-x-circle-fill"></i></div><div class="stat-info"><div class="stat-number"><?= $rejected ?></div><div class="stat-label">Rejected</div></div></div></div>
        </div>

        <div class="card student-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr><th>#</th><th>Company</th><th>Location</th><th>Package</th><th>Drive Date</th><th>Applied On</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ($apps as $i => $a): ?>
                            <tr>
                                <td class="text-muted"><?= $i + 1 ?></td>
                                <td><strong><?= htmlspecialchars($a['company_name']) ?></strong></td>
                                <td><small><?= htmlspecialchars($a['location'] ?? '-') ?></small></td>
                                <td><span class="badge bg-success"><?= htmlspecialchars($a['package'] ?? '-') ?></span></td>
                                <td><?= $a['drive_date'] ? date('d M Y', strtotime($a['drive_date'])) : '<span class="text-muted">-</span>' ?></td>
                                <td><small><?= date('d M Y', strtotime($a['applied_at'])) ?></small></td>
                                <td>
                                    <?php
                                    $badgeMap = ['pending'=>'warning text-dark','accepted'=>'success','rejected'=>'danger'];
                                    $badge    = $badgeMap[$a['status']] ?? 'secondary';
                                    $iconMap  = ['pending'=>'hourglass-split','accepted'=>'check-circle-fill','rejected'=>'x-circle-fill'];
                                    $icon     = $iconMap[$a['status']] ?? 'circle';
                                    ?>
                                    <span class="badge bg-<?= $badge ?> d-flex align-items-center gap-1" style="width:fit-content">
                                        <i class="bi bi-<?= $icon ?>"></i> <?= ucfirst($a['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
