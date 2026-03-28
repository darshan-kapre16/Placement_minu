<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="admin-layout">
<?php require __DIR__ . '/sidebar.php'; ?>
<div class="main-content">
    <div class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <h1 class="page-title">Applications</h1>
    </div>

    <div class="content-body">
        <?php if (!empty($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>Application status updated.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Filter Bar -->
        <div class="d-flex gap-2 mb-4 flex-wrap">
            <?php
            $filterMap = ['' => 'All', 'pending' => 'Pending', 'accepted' => 'Accepted', 'rejected' => 'Rejected'];
            $currentFilter = $_GET['filter'] ?? '';
            foreach ($filterMap as $val => $label):
                $active = ($currentFilter === $val) ? 'btn-primary' : 'btn-outline-secondary';
            ?>
                <a href="index.php?page=admin_applications&filter=<?= $val ?>" class="btn btn-sm <?= $active ?>"><?= $label ?></a>
            <?php endforeach; ?>
            <span class="ms-auto text-muted small align-self-center"><?= count($applications) ?> records</span>
        </div>

        <div class="card admin-card">
            <div class="card-body p-0">
                <?php if (empty($applications)): ?>
                    <div class="empty-state py-5"><i class="bi bi-file-earmark-x"></i><p>No applications found.</p></div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr><th>#</th><th>Student</th><th>Company</th><th>Package</th><th>Applied</th><th>Status</th><th>Resume</th><th>Actions</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ($applications as $i => $a): ?>
                            <tr>
                                <td class="text-muted small"><?= $i + 1 ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($a['student_name']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($a['email']) ?></small><br>
                                    <small class="text-info"><?= htmlspecialchars($a['branch'] ?? '') ?> | CGPA: <?= number_format((float)($a['cgpa']??0),2) ?></small>
                                </td>
                                <td><strong><?= htmlspecialchars($a['company_name']) ?></strong></td>
                                <td><span class="badge bg-success"><?= htmlspecialchars($a['package'] ?? '-') ?></span></td>
                                <td><small><?= date('d M Y', strtotime($a['applied_at'])) ?></small></td>
                                <td>
                                    <?php
                                    $badgeMap = ['pending'=>'warning text-dark','accepted'=>'success','rejected'=>'danger'];
                                    $badge = $badgeMap[$a['status']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $badge ?>"><?= ucfirst($a['status']) ?></span>
                                </td>
                                <td>
                                    <?php if ($a['resume']): ?>
                                        <a href="<?= UPLOAD_URL . htmlspecialchars($a['resume']) ?>" target="_blank" class="btn btn-xs btn-outline-info">
                                            <i class="bi bi-file-pdf"></i> View
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" action="index.php?action=update_application" class="d-flex gap-1">
                                        <input type="hidden" name="id" value="<?= $a['id'] ?>">
                                        <?php if ($a['status'] !== 'accepted'): ?>
                                            <button name="status" value="accepted" class="btn btn-xs btn-outline-success" onclick="return confirm('Accept this application?')">
                                                <i class="bi bi-check-circle"></i> Accept
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($a['status'] !== 'rejected'): ?>
                                            <button name="status" value="rejected" class="btn btn-xs btn-outline-danger" onclick="return confirm('Reject this application?')">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($a['status'] !== 'pending'): ?>
                                            <button name="status" value="pending" class="btn btn-xs btn-outline-warning">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/admin.js"></script>
</body>
</html>
