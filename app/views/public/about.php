<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | T&P Cell</title>
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
                <li class="nav-item"><a href="index.php?page=about" class="nav-link active">About</a></li>
                <li class="nav-item"><a href="index.php?page=companies" class="nav-link">Companies</a></li>
                <li class="nav-item ms-2"><a href="login.php?type=student" class="btn btn-outline-primary btn-sm">Student Login</a></li>
                <li class="nav-item"><a href="index.php?page=register" class="btn btn-primary btn-sm">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="page-hero-sm">
    <div class="container text-center">
        <h1><i class="bi bi-info-circle me-2"></i>About Placement Cell</h1>
        <p class="text-white-50">Bridging the gap between talented students and leading industries</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <span class="section-badge">Who We Are</span>
                <h2 class="mt-2 mb-4">Training & Placement Cell</h2>
                <p class="text-muted">The Training and Placement Cell is the central body responsible for assisting students in getting placed in leading companies across various industries. We serve as the interface between the institute and prospective employers.</p>
                <p class="text-muted">Our dedicated team works year-round to ensure that students are industry-ready and that top companies choose our institute for campus recruitment.</p>
                <div class="row g-3 mt-2">
                    <div class="col-6"><div class="about-feature"><i class="bi bi-check-circle-fill text-primary me-2"></i>Career Guidance</div></div>
                    <div class="col-6"><div class="about-feature"><i class="bi bi-check-circle-fill text-primary me-2"></i>Resume Building</div></div>
                    <div class="col-6"><div class="about-feature"><i class="bi bi-check-circle-fill text-primary me-2"></i>Mock Interviews</div></div>
                    <div class="col-6"><div class="about-feature"><i class="bi bi-check-circle-fill text-primary me-2"></i>Industry Connect</div></div>
                    <div class="col-6"><div class="about-feature"><i class="bi bi-check-circle-fill text-primary me-2"></i>Skill Development</div></div>
                    <div class="col-6"><div class="about-feature"><i class="bi bi-check-circle-fill text-primary me-2"></i>Campus Drives</div></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-cards">
                    <div class="about-stat-card">
                        <div class="asc-icon bg-primary"><i class="bi bi-building-fill"></i></div>
                        <div><h4><?= $stats['companies'] ?>+</h4><p>Companies Registered</p></div>
                    </div>
                    <div class="about-stat-card">
                        <div class="asc-icon bg-success"><i class="bi bi-trophy-fill"></i></div>
                        <div><h4><?= $stats['placed'] ?>+</h4><p>Students Placed</p></div>
                    </div>
                    <div class="about-stat-card">
                        <div class="asc-icon bg-warning"><i class="bi bi-calendar-event-fill"></i></div>
                        <div><h4><?= $stats['drives'] ?>+</h4><p>Drives Conducted</p></div>
                    </div>
                    <div class="about-stat-card">
                        <div class="asc-icon bg-info"><i class="bi bi-people-fill"></i></div>
                        <div><h4><?= $stats['students'] ?>+</h4><p>Registered Students</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-badge">Process</span>
            <h2>How It Works</h2>
        </div>
        <div class="row g-4">
            <?php
            $steps = [
                ['icon'=>'person-plus-fill','color'=>'primary','title'=>'1. Register','desc'=>'Create your student account with academic details.'],
                ['icon'=>'file-earmark-pdf-fill','color'=>'danger','title'=>'2. Upload Resume','desc'=>'Upload your updated resume in PDF/DOC format.'],
                ['icon'=>'person-check-fill','color'=>'success','title'=>'3. Get Approved','desc'=>'Admin reviews and approves your profile.'],
                ['icon'=>'building-fill','color'=>'warning','title'=>'4. Browse Companies','desc'=>'View available placement drives and eligibility.'],
                ['icon'=>'send-fill','color'=>'info','title'=>'5. Apply','desc'=>'Apply to companies that match your profile.'],
                ['icon'=>'trophy-fill','color'=>'purple','title'=>'6. Get Placed!','desc'=>'Track your application status and celebrate your placement.'],
            ];
            foreach ($steps as $s):
            ?>
            <div class="col-md-4 col-lg-2">
                <div class="process-step text-center">
                    <div class="process-icon bg-<?= $s['color'] ?>"><i class="bi bi-<?= $s['icon'] ?>"></i></div>
                    <h6 class="mt-3"><?= $s['title'] ?></h6>
                    <small class="text-muted"><?= $s['desc'] ?></small>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section py-5">
    <div class="container text-center">
        <h2 class="text-white">Start Your Journey Today</h2>
        <p class="text-white-50 mb-4">Join hundreds of students who have launched their careers through our placement cell.</p>
        <a href="index.php?page=register" class="btn btn-light btn-lg px-5">Register Now</a>
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
