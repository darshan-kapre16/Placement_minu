<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="admin-layout">
<?php require __DIR__ . '/sidebar.php'; ?>
<div class="main-content">
    <div class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <h1 class="page-title">Manage Students</h1>
    </div>

    <div class="content-body">
        <?php if (!empty($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>
                <?= ['updated'=>'Student updated.','deleted'=>'Student deleted.'][$_GET['msg']] ?? 'Done.' ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card admin-card">
            <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people-fill me-2 text-primary"></i>All Students
                    <span class="badge bg-primary ms-2"><?= count($students) ?></span>
                </h5>
                <form method="GET" class="d-flex gap-2">
                    <input type="hidden" name="page" value="admin_students">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name/email/branch..." value="<?= htmlspecialchars($search) ?>" style="min-width:220px">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
                    <?php if ($search): ?><a href="index.php?page=admin_students" class="btn btn-sm btn-outline-secondary">Clear</a><?php endif; ?>
                </form>
            </div>
            <div class="card-body p-0">
                <?php if (empty($students)): ?>
                    <div class="empty-state py-5"><i class="bi bi-people"></i><p>No students found.</p></div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th><th>Name</th><th>Email</th><th>Branch</th><th>CGPA</th>
                                <th>Resume</th><th>Status</th><th>Placed</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($students as $i => $s): ?>
                            <tr>
                                <td class="text-muted small"><?= $i + 1 ?></td>
                                <td><strong><?= htmlspecialchars($s['name']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($s['phone'] ?? '') ?></small></td>
                                <td><small><?= htmlspecialchars($s['email']) ?></small></td>
                                <td><?= htmlspecialchars($s['branch'] ?? '-') ?>
                                    <br><small class="text-muted"><?= htmlspecialchars($s['year'] ?? '') ?></small></td>
                                <td><?= number_format((float)($s['cgpa'] ?? 0), 2) ?></td>
                                <td>
                                    <?php if ($s['resume']): ?>
                                        <a href="<?= UPLOAD_URL . htmlspecialchars($s['resume']) ?>" target="_blank" class="btn btn-xs btn-outline-info">
                                            <i class="bi bi-file-pdf"></i> View
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">Not uploaded</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($s['approved']): ?>
                                        <span class="badge bg-success">Approved</span>
                                        <a href="index.php?action=approve_student&id=<?= $s['id'] ?>&approved=0" class="badge bg-warning text-dark ms-1" onclick="return confirm('Unapprove this student?')">Unapprove</a>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        <a href="index.php?action=approve_student&id=<?= $s['id'] ?>&approved=1" class="badge bg-success ms-1">Approve</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($s['placed']): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" action="index.php?action=delete_student" class="d-inline"
                                          onsubmit="return confirm('Delete student <?= htmlspecialchars(addslashes($s['name'])) ?>? This cannot be undone.')">
                                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                        <button class="btn btn-xs btn-outline-danger"><i class="bi bi-trash"></i></button>
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
