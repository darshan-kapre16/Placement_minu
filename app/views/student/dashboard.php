<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard | Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="student-layout">

<!-- Student Navbar -->
<nav class="navbar student-navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=student_dashboard">
            <i class="bi bi-mortarboard-fill me-2"></i>Placement Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#stuNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="stuNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item"><a href="index.php?page=student_dashboard" class="nav-link active"><i class="bi bi-grid me-1"></i>Dashboard</a></li>
                <li class="nav-item"><a href="index.php?page=student_apply" class="nav-link"><i class="bi bi-send me-1"></i>Apply</a></li>
                <li class="nav-item"><a href="index.php?page=student_applications" class="nav-link"><i class="bi bi-file-text me-1"></i>My Applications</a></li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($student['name']) ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header"><?= htmlspecialchars($student['email']) ?></h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php?action=student_logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="student-content">
    <?php
    $msgMap = [
        'resume_uploaded' => ['success', 'Resume uploaded successfully!'],
        'no_file'         => ['warning', 'Please select a file to upload.'],
        'invalid_file'    => ['danger', 'Only PDF, DOC, DOCX files are allowed.'],
        'file_too_large'  => ['danger', 'File size must be under 2MB.'],
    ];
    $msg = $_GET['msg'] ?? '';
    if ($msg && isset($msgMap[$msg])): [$type, $text] = $msgMap[$msg]; ?>
        <div class="alert alert-<?= $type ?> alert-dismissible fade show mb-3">
            <i class="bi bi-<?= $type==='success'?'check-circle':'exclamation-triangle' ?> me-2"></i><?= $text ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Status Banner -->
    <?php if (!$student['approved']): ?>
        <div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-clock-history fs-4"></i>
            <div><strong>Pending Approval</strong> — Your account is awaiting admin approval. You won't be able to apply to companies until approved.</div>
        </div>
    <?php elseif ($student['placed']): ?>
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-trophy-fill fs-4"></i>
            <div><strong>Congratulations!</strong> You have been successfully placed. Best wishes for your career!</div>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card student-card profile-card">
                <div class="card-body text-center">
                    <div class="student-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h4 class="mt-3"><?= htmlspecialchars($student['name']) ?></h4>
                    <p class="text-muted mb-0"><?= htmlspecialchars($student['branch'] ?? 'N/A') ?> | <?= htmlspecialchars($student['year'] ?? '') ?></p>
                    <p class="text-muted small"><?= htmlspecialchars($student['email']) ?></p>
                    <div class="d-flex justify-content-center gap-3 my-3">
                        <div class="text-center">
                            <div class="fw-bold text-primary"><?= number_format((float)($student['cgpa']??0),2) ?></div>
                            <div class="text-muted small">CGPA</div>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold text-success"><?= count($apps) ?></div>
                            <div class="text-muted small">Applications</div>
                        </div>
                        <div class="text-center">
                            <div class="fw-bold text-warning"><?= $student['approved'] ? '<span class="text-success">✓</span>' : '⏳' ?></div>
                            <div class="text-muted small">Status</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge <?= $student['approved'] ? 'bg-success' : 'bg-warning text-dark' ?> flex-grow-1">
                            <?= $student['approved'] ? 'Approved' : 'Pending Approval' ?>
                        </span>
                        <span class="badge <?= $student['placed'] ? 'bg-success' : 'bg-secondary' ?> flex-grow-1">
                            <?= $student['placed'] ? 'Placed ✓' : 'Not Placed' ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Resume Upload -->
            <div class="card student-card mt-3">
                <div class="card-header"><h6 class="mb-0"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>My Resume</h6></div>
                <div class="card-body">
                    <?php if ($student['resume']): ?>
                        <div class="d-flex align-items-center gap-2 mb-3 p-2 bg-light rounded">
                            <i class="bi bi-file-pdf-fill text-danger fs-4"></i>
                            <div class="flex-grow-1">
                                <div class="fw-bold small">Resume Uploaded</div>
                                <small class="text-muted"><?= htmlspecialchars($student['resume']) ?></small>
                            </div>
                            <a href="<?= UPLOAD_URL . htmlspecialchars($student['resume']) ?>" target="_blank" class="btn btn-sm btn-outline-info">View</a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-2 text-muted">
                            <i class="bi bi-file-earmark-x fs-2 d-block mb-1"></i>
                            <small>No resume uploaded</small>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="index.php?action=upload_resume" enctype="multipart/form-data">
                        <input type="file" name="resume" class="form-control form-control-sm mb-2" accept=".pdf,.doc,.docx" required>
                        <small class="text-muted d-block mb-2">PDF/DOC/DOCX, max 2MB</small>
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="bi bi-cloud-upload me-1"></i><?= $student['resume'] ? 'Update Resume' : 'Upload Resume' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Upcoming Drives -->
            <div class="card student-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-calendar-event me-2 text-success"></i>Upcoming Drives</h6>
                    <a href="index.php?page=student_apply" class="btn btn-sm btn-success">Apply Now</a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($drives)): ?>
                        <div class="empty-state py-3"><i class="bi bi-calendar-x"></i><p>No upcoming drives.</p></div>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead><tr><th>Company</th><th>Package</th><th>Date</th><th>Status</th></tr></thead>
                            <tbody>
                            <?php foreach (array_slice($drives, 0, 5) as $d): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($d['company_name']) ?></strong><br>
                                        <small class="text-muted"><i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($d['location'] ?? '') ?></small></td>
                                    <td><span class="badge bg-success"><?= htmlspecialchars($d['package'] ?? '') ?></span></td>
                                    <td><?= date('d M Y', strtotime($d['drive_date'])) ?></td>
                                    <td><span class="badge bg-<?= $d['status']==='upcoming'?'primary':'warning' ?>"><?= ucfirst($d['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Notices -->
            <div class="card student-card mb-4">
                <div class="card-header"><h6 class="mb-0"><i class="bi bi-bell me-2 text-warning"></i>Latest Notices</h6></div>
                <div class="card-body">
                    <?php if (empty($notices)): ?>
                        <div class="empty-state py-2"><i class="bi bi-bell-slash"></i><p>No notices.</p></div>
                    <?php else: ?>
                        <?php foreach (array_slice($notices, 0, 4) as $n): ?>
                            <div class="notice-item">
                                <div class="notice-dot"></div>
                                <div>
                                    <div class="notice-title"><?= htmlspecialchars($n['title']) ?></div>
                                    <?php if ($n['content']): ?>
                                        <div class="text-muted small"><?= htmlspecialchars(substr($n['content'], 0, 100)) ?><?= strlen($n['content'])>100?'...':'' ?></div>
                                    <?php endif; ?>
                                    <div class="notice-date"><i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($n['created_at'])) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- My Recent Applications -->
            <?php if (!empty($apps)): ?>
            <div class="card student-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-file-text me-2 text-primary"></i>Recent Applications</h6>
                    <a href="index.php?page=student_applications" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead><tr><th>Company</th><th>Package</th><th>Applied</th><th>Status</th></tr></thead>
                            <tbody>
                            <?php foreach (array_slice($apps, 0, 4) as $a): ?>
                                <tr>
                                    <td><?= htmlspecialchars($a['company_name']) ?></td>
                                    <td><span class="badge bg-success"><?= htmlspecialchars($a['package']??'') ?></span></td>
                                    <td><?= date('d M', strtotime($a['applied_at'])) ?></td>
                                    <td>
                                        <?php $b=['pending'=>'warning text-dark','accepted'=>'success','rejected'=>'danger'][$a['status']]??'secondary' ?>
                                        <span class="badge bg-<?= $b ?>"><?= ucfirst($a['status']) ?></span>
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
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
