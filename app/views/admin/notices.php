<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="admin-layout">
<?php require __DIR__ . '/sidebar.php'; ?>
<div class="main-content">
    <div class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <h1 class="page-title">Notice Management</h1>
    </div>

    <div class="content-body">
        <?php
        $msg = $_GET['msg'] ?? '';
        if ($msg === 'added'): ?>
            <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Notice published successfully.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php elseif ($msg === 'deleted'): ?>
            <div class="alert alert-info alert-dismissible fade show"><i class="bi bi-info-circle me-2"></i>Notice deleted.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Add Notice Form -->
            <div class="col-lg-4">
                <div class="card admin-card">
                    <div class="card-header"><h6 class="mb-0"><i class="bi bi-bell-plus me-2"></i>Post New Notice</h6></div>
                    <div class="card-body">
                        <form method="POST" action="index.php?action=add_notice" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Notice Title *</label>
                                <input type="text" name="title" class="form-control" required placeholder="Enter notice title...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Content</label>
                                <textarea name="content" class="form-control" rows="4" placeholder="Notice details..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Attach File <small class="text-muted">(PDF/DOC/Image, optional)</small></label>
                                <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                            </div>
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="bi bi-bell-fill me-2"></i>Publish Notice
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Notices List -->
            <div class="col-lg-8">
                <div class="card admin-card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="bi bi-bell-fill me-2 text-warning"></i>All Notices <span class="badge bg-warning text-dark"><?= count($notices) ?></span></h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($notices)): ?>
                            <div class="empty-state py-4"><i class="bi bi-bell-slash"></i><p>No notices yet.</p></div>
                        <?php else: ?>
                            <?php foreach ($notices as $n): ?>
                                <div class="notice-card">
                                    <div class="notice-card-header">
                                        <div>
                                            <h6 class="mb-1"><?= htmlspecialchars($n['title']) ?></h6>
                                            <small class="text-muted"><i class="bi bi-clock me-1"></i><?= date('d M Y, h:i A', strtotime($n['created_at'])) ?></small>
                                        </div>
                                        <form method="POST" action="index.php?action=delete_notice"
                                              onsubmit="return confirm('Delete this notice?')">
                                            <input type="hidden" name="id" value="<?= $n['id'] ?>">
                                            <button class="btn btn-xs btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                    <?php if ($n['content']): ?>
                                        <p class="text-muted small mt-2 mb-1"><?= nl2br(htmlspecialchars($n['content'])) ?></p>
                                    <?php endif; ?>
                                    <?php if ($n['file']): ?>
                                        <a href="#" class="badge bg-info text-decoration-none">
                                            <i class="bi bi-paperclip me-1"></i>Attachment
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/admin.js"></script>
</body>
</html>
