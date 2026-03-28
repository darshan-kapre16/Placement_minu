<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Companies | T&P Cell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="public-layout">
<nav class="navbar public-navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php?page=home"><i class="bi bi-mortarboard-fill me-2"></i>T&P Cell</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#pubNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="pubNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item"><a href="index.php?page=home" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="index.php?page=about" class="nav-link">About</a></li>
                <li class="nav-item"><a href="index.php?page=companies" class="nav-link active">Companies</a></li>
                <li class="nav-item ms-2"><a href="login.php?type=student" class="btn btn-outline-primary btn-sm">Student Login</a></li>
                <li class="nav-item"><a href="index.php?page=register" class="btn btn-primary btn-sm">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="page-hero-sm">
    <div class="container text-center">
        <h1><i class="bi bi-building-fill me-2"></i>Companies That Recruit Here</h1>
        <p class="text-white-50">Top organizations that regularly visit our campus for placements</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <?php if (empty($companies)): ?>
            <div class="text-center text-muted py-5"><i class="bi bi-building fs-1 d-block mb-3"></i>No companies listed yet.</div>
        <?php else: ?>
        <div class="row g-4">
            <?php foreach ($companies as $c): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card public-company-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3">
                            <div class="company-icon-box"><i class="bi bi-building-fill"></i></div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1"><?= htmlspecialchars($c['company_name']) ?></h5>
                                <div class="text-muted small mb-2">
                                    <i class="bi bi-geo-alt me-1"></i><?= htmlspecialchars($c['location'] ?? 'N/A') ?>
                                </div>
                                <span class="badge bg-success"><i class="bi bi-currency-rupee me-1"></i><?= htmlspecialchars($c['package'] ?? 'N/A') ?></span>
                            </div>
                        </div>
                        <?php if ($c['description']): ?>
                            <p class="text-muted small mt-3 mb-0"><?= htmlspecialchars(substr($c['description'], 0, 120)) ?><?= strlen($c['description'])>120?'...':'' ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if ($c['website']): ?>
                    <div class="card-footer bg-transparent">
                        <a href="<?= htmlspecialchars($c['website']) ?>" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-globe me-1"></i>Visit Website
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<footer class="public-footer py-4">
    <div class="container text-center text-muted">
        <small>&copy; <?= date('Y') ?> Training & Placement Cell. All rights reserved.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
