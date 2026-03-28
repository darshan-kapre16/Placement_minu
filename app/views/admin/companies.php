<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Companies & Drives | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="admin-layout">
<?php require __DIR__ . '/sidebar.php'; ?>
<div class="main-content">
    <div class="topbar">
        <button class="sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>
        <h1 class="page-title">Companies & Drives</h1>
    </div>

    <div class="content-body">
        <?php
        $msgs = ['added'=>'Company added.','updated'=>'Company updated.','deleted'=>'Company deleted.',
                 'drive_added'=>'Drive added.','drive_updated'=>'Drive updated.','drive_deleted'=>'Drive deleted.'];
        if (!empty($_GET['msg']) && isset($msgs[$_GET['msg']])): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i><?= $msgs[$_GET['msg']] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="compTabs">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#companies-tab">
                <i class="bi bi-building me-1"></i>Companies</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#drives-tab">
                <i class="bi bi-calendar-event me-1"></i>Placement Drives</a></li>
        </ul>

        <div class="tab-content">
            <!-- COMPANIES TAB -->
            <div class="tab-pane fade show active" id="companies-tab">
                <div class="row g-4">
                    <!-- Add / Edit Company Form -->
                    <div class="col-lg-4">
                        <div class="card admin-card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-<?= $edit ? 'pencil' : 'plus-circle' ?> me-2"></i>
                                    <?= $edit ? 'Edit Company' : 'Add New Company' ?></h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="index.php?action=<?= $edit ? 'edit_company' : 'add_company' ?>">
                                    <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif; ?>
                                    <div class="mb-3">
                                        <label class="form-label">Company Name *</label>
                                        <input type="text" name="company_name" class="form-control" required value="<?= htmlspecialchars($edit['company_name'] ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Location</label>
                                        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($edit['location'] ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Package</label>
                                        <input type="text" name="package" class="form-control" placeholder="e.g. 4.5 LPA" value="<?= htmlspecialchars($edit['package'] ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Website</label>
                                        <input type="url" name="website" class="form-control" placeholder="https://..." value="<?= htmlspecialchars($edit['website'] ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($edit['description'] ?? '') ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-<?= $edit ? 'check-circle' : 'plus-circle' ?> me-2"></i>
                                        <?= $edit ? 'Update Company' : 'Add Company' ?>
                                    </button>
                                    <?php if ($edit): ?>
                                        <a href="index.php?page=admin_companies" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Companies List -->
                    <div class="col-lg-8">
                        <div class="card admin-card">
                            <div class="card-header"><h6 class="mb-0"><i class="bi bi-building-fill me-2 text-primary"></i>All Companies <span class="badge bg-primary"><?= count($companies) ?></span></h6></div>
                            <div class="card-body p-0">
                                <?php if (empty($companies)): ?>
                                    <div class="empty-state py-4"><i class="bi bi-building"></i><p>No companies yet.</p></div>
                                <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead><tr><th>Company</th><th>Location</th><th>Package</th><th>Actions</th></tr></thead>
                                        <tbody>
                                        <?php foreach ($companies as $c): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($c['company_name']) ?></strong>
                                                    <?php if ($c['website']): ?>
                                                        <a href="<?= htmlspecialchars($c['website']) ?>" target="_blank" class="ms-1 text-muted"><i class="bi bi-box-arrow-up-right small"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                                <td><small><?= htmlspecialchars($c['location'] ?? '-') ?></small></td>
                                                <td><span class="badge bg-success"><?= htmlspecialchars($c['package'] ?? '-') ?></span></td>
                                                <td>
                                                    <a href="index.php?page=admin_companies&edit=<?= $c['id'] ?>#companies-tab" class="btn btn-xs btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                                    <form method="POST" action="index.php?action=delete_company" class="d-inline"
                                                          onsubmit="return confirm('Delete <?= htmlspecialchars(addslashes($c['company_name'])) ?>?')">
                                                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
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
            </div>

            <!-- DRIVES TAB -->
            <div class="tab-pane fade" id="drives-tab">
                <div class="row g-4">
                    <!-- Add/Edit Drive Form -->
                    <div class="col-lg-4">
                        <div class="card admin-card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-calendar-plus me-2"></i><?= $editDrive ? 'Edit Drive' : 'Add Drive' ?></h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="index.php?action=<?= $editDrive ? 'edit_drive' : 'add_drive' ?>">
                                    <?php if ($editDrive): ?><input type="hidden" name="id" value="<?= $editDrive['id'] ?>"><?php endif; ?>
                                    <div class="mb-3">
                                        <label class="form-label">Company *</label>
                                        <select name="company_id" class="form-select" required>
                                            <option value="">-- Select Company --</option>
                                            <?php foreach ($companies as $c): ?>
                                                <option value="<?= $c['id'] ?>" <?= (!empty($editDrive) && $editDrive['company_id'] == $c['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($c['company_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Drive Date *</label>
                                        <input type="date" name="drive_date" class="form-control" required value="<?= htmlspecialchars($editDrive['drive_date'] ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <?php foreach (['upcoming','ongoing','completed'] as $s): ?>
                                                <option value="<?= $s ?>" <?= (!empty($editDrive) && $editDrive['status'] === $s) ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Eligibility</label>
                                        <textarea name="eligibility" class="form-control" rows="2" placeholder="CGPA >= 6.5, No backlogs..."><?= htmlspecialchars($editDrive['eligibility'] ?? '') ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="2"><?= htmlspecialchars($editDrive['description'] ?? '') ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <?= $editDrive ? 'Update Drive' : 'Add Drive' ?>
                                    </button>
                                    <?php if ($editDrive): ?>
                                        <a href="index.php?page=admin_companies" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Drives List -->
                    <div class="col-lg-8">
                        <div class="card admin-card">
                            <div class="card-header"><h6 class="mb-0"><i class="bi bi-calendar-event-fill me-2 text-success"></i>All Drives <span class="badge bg-success"><?= count($drives) ?></span></h6></div>
                            <div class="card-body p-0">
                                <?php if (empty($drives)): ?>
                                    <div class="empty-state py-4"><i class="bi bi-calendar-x"></i><p>No drives yet.</p></div>
                                <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead><tr><th>Company</th><th>Date</th><th>Status</th><th>Eligibility</th><th>Actions</th></tr></thead>
                                        <tbody>
                                        <?php foreach ($drives as $d): ?>
                                            <tr>
                                                <td><strong><?= htmlspecialchars($d['company_name']) ?></strong></td>
                                                <td><?= date('d M Y', strtotime($d['drive_date'])) ?></td>
                                                <td><span class="badge bg-<?= $d['status']==='upcoming'?'success':($d['status']==='ongoing'?'warning':'secondary') ?>">
                                                    <?= ucfirst($d['status']) ?></span></td>
                                                <td><small class="text-muted"><?= htmlspecialchars(substr($d['eligibility'] ?? '-', 0, 50)) ?><?= strlen($d['eligibility'] ?? '') > 50 ? '...' : '' ?></small></td>
                                                <td>
                                                    <a href="index.php?page=admin_companies&edit_drive=<?= $d['id'] ?>" class="btn btn-xs btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                                    <form method="POST" action="index.php?action=delete_drive" class="d-inline"
                                                          onsubmit="return confirm('Delete this drive?')">
                                                        <input type="hidden" name="id" value="<?= $d['id'] ?>">
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
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/admin.js"></script>
<script>
// Auto-activate drives tab if editing a drive
<?php if ($editDrive): ?>
document.addEventListener('DOMContentLoaded', function() {
    new bootstrap.Tab(document.querySelector('[href="#drives-tab"]')).show();
});
<?php endif; ?>
</script>
</body>
</html>
