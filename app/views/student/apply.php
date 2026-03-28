<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply | Student Portal</title>
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
                <li class="nav-item"><a href="index.php?page=student_apply" class="nav-link active"><i class="bi bi-send me-1"></i>Apply</a></li>
                <li class="nav-item"><a href="index.php?page=student_applications" class="nav-link"><i class="bi bi-file-text me-1"></i>My Applications</a></li>
                <li class="nav-item"><a href="index.php?action=student_logout" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="student-content">
    <?php
    $msgMap = [
        'applied'       => ['success', '<i class="bi bi-check-circle me-2"></i>Application submitted successfully!'],
        'already_applied'=> ['warning', '<i class="bi bi-exclamation-circle me-2"></i>You have already applied to this company.'],
        'not_approved'  => ['danger',  '<i class="bi bi-x-circle me-2"></i>Your account is not yet approved. Please wait for admin approval.'],
        'no_resume'     => ['danger',  '<i class="bi bi-file-earmark-x me-2"></i>Please upload your resume before applying.'],
    ];
    $msg = $_GET['msg'] ?? '';
    if ($msg && isset($msgMap[$msg])): [$type, $text] = $msgMap[$msg]; ?>
        <div class="alert alert-<?= $type ?> alert-dismissible fade show">
            <?= $text ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Warnings -->
    <?php if (!$student['approved']): ?>
        <div class="alert alert-warning"><i class="bi bi-clock-history me-2"></i>Your account needs admin approval before you can apply.</div>
    <?php endif; ?>
    <?php if (empty($student['resume'])): ?>
        <div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Please <a href="index.php?page=student_dashboard" class="alert-link">upload your resume</a> first before applying.</div>
    <?php endif; ?>

    <h4 class="mb-4"><i class="bi bi-calendar-event me-2 text-success"></i>Available Placement Drives</h4>

    <?php if (empty($drives)): ?>
        <div class="card student-card">
            <div class="empty-state py-5"><i class="bi bi-calendar-x"></i><p>No upcoming placement drives at the moment.</p></div>
        </div>
    <?php else: ?>
    <div class="row g-4">
        <?php foreach ($drives as $d):
            $alreadyApplied = in_array($d['company_id'], $appliedCompanies);
            $canApply = $student['approved'] && !empty($student['resume']) && !$alreadyApplied;
        ?>
        <div class="col-md-6 col-lg-4">
            <div class="card student-card drive-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0"><?= htmlspecialchars($d['company_name']) ?></h5>
                        <span class="badge bg-<?= $d['status']==='upcoming'?'success':'warning' ?>"><?= ucfirst($d['status']) ?></span>
                    </div>
                    <div class="drive-meta">
                        <div><i class="bi bi-geo-alt me-2 text-muted"></i><?= htmlspecialchars($d['location'] ?? 'N/A') ?></div>
                        <div><i class="bi bi-currency-rupee me-2 text-success"></i><?= htmlspecialchars($d['package'] ?? 'N/A') ?></div>
                        <div><i class="bi bi-calendar me-2 text-primary"></i><?= date('d M Y', strtotime($d['drive_date'])) ?></div>
                    </div>
                    <?php if ($d['eligibility']): ?>
                        <div class="eligibility-box mt-2">
                            <small><strong>Eligibility:</strong> <?= htmlspecialchars($d['eligibility']) ?></small>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-transparent">
                    <?php if ($alreadyApplied): ?>
                        <button class="btn btn-success w-100" disabled>
                            <i class="bi bi-check-circle me-2"></i>Applied
                        </button>
                    <?php elseif ($canApply): ?>
                        <form method="POST" action="index.php?action=apply" onsubmit="return confirm('Apply to <?= htmlspecialchars(addslashes($d['company_name'])) ?>?')">
                            <input type="hidden" name="company_id" value="<?= $d['company_id'] ?>">
                            <input type="hidden" name="drive_id" value="<?= $d['id'] ?>">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-send me-2"></i>Apply Now
                            </button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-outline-secondary w-100" disabled>
                            <i class="bi bi-lock me-2"></i>Cannot Apply
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
