<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training & Placement Cell | Official Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        html{scroll-behavior:smooth;}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#fff;color:#1e293b;}

        /* ── NAVBAR ── */
        .pub-nav{
            position:fixed;top:0;left:0;right:0;z-index:999;
            background:rgba(8,10,28,.82);
            backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);
            border-bottom:1px solid rgba(255,255,255,.07);
            padding:12px 0;
            transition:background .3s;
        }
        .pub-nav.scrolled{background:rgba(8,10,28,.97);}
        .pub-nav .navbar-brand{
            font-weight:800;font-size:1.12rem;color:#fff!important;
            display:flex;align-items:center;gap:10px;text-decoration:none;
        }
        .brand-dot{
            width:36px;height:36px;border-radius:10px;
            background:linear-gradient(135deg,#2563eb,#7c3aed);
            display:flex;align-items:center;justify-content:center;
            font-size:1rem;color:#fff;
        }
        .pub-nav .nav-link{
            color:rgba(255,255,255,.7)!important;font-weight:500;font-size:.88rem;
            padding:6px 14px!important;border-radius:6px;transition:color .2s,background .2s;
        }
        .pub-nav .nav-link:hover,.pub-nav .nav-link.active{color:#fff!important;background:rgba(255,255,255,.1);}
        .btn-nav-login{
            background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.25);
            color:#fff!important;border-radius:8px;padding:7px 18px!important;
            font-weight:600!important;font-size:.88rem;
            transition:background .2s!important;
        }
        .btn-nav-login:hover{background:rgba(255,255,255,.18)!important;}
        .btn-nav-reg{
            background:linear-gradient(135deg,#2563eb,#7c3aed);
            border:none;color:#fff!important;border-radius:8px;
            padding:7px 18px!important;font-weight:700!important;font-size:.88rem;
        }

        /* ── HERO ── */
        #hero{
            min-height:100vh;
            background:radial-gradient(ellipse 90% 70% at 50% -5%,#1d3461 0%,#080a1c 65%);
            display:flex;align-items:center;padding-top:76px;
            position:relative;overflow:hidden;
        }
        .hero-grid{
            position:absolute;inset:0;
            background-image:
                linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),
                linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
            background-size:60px 60px;
            mask-image:radial-gradient(ellipse 80% 80% at 50% 0%,#000 40%,transparent 100%);
        }
        .hero-glow{
            position:absolute;width:700px;height:700px;
            background:radial-gradient(circle,rgba(37,99,235,.14) 0%,transparent 70%);
            top:-150px;left:50%;transform:translateX(-50%);pointer-events:none;
        }
        .hero-badge{
            display:inline-flex;align-items:center;gap:8px;
            background:rgba(37,99,235,.15);border:1px solid rgba(37,99,235,.4);
            color:#93c5fd;padding:6px 18px;border-radius:100px;
            font-size:.78rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;
            margin-bottom:26px;
        }
        .hero-title{
            font-size:clamp(2.2rem,5.5vw,3.8rem);
            font-weight:900;color:#fff;line-height:1.1;margin-bottom:20px;
        }
        .grad-text{
            background:linear-gradient(90deg,#60a5fa,#a78bfa,#f472b6);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
        }
        .hero-sub{color:rgba(255,255,255,.6);font-size:1.02rem;line-height:1.75;max-width:510px;margin-bottom:36px;}
        .btn-primary-hero{
            background:linear-gradient(135deg,#2563eb,#7c3aed);border:none;
            color:#fff;padding:13px 30px;border-radius:12px;font-weight:700;
            font-size:.95rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;
            box-shadow:0 8px 24px rgba(37,99,235,.4);transition:transform .2s,box-shadow .2s;
        }
        .btn-primary-hero:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(37,99,235,.5);color:#fff;}
        .btn-ghost-hero{
            background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.2);
            color:#fff;padding:13px 30px;border-radius:12px;font-weight:600;
            font-size:.95rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;
            transition:background .2s;
        }
        .btn-ghost-hero:hover{background:rgba(255,255,255,.14);color:#fff;}

        /* Hero Visual */
        .h-visual{position:relative;height:430px;}
        .h-center{
            position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
            width:108px;height:108px;border-radius:28px;
            background:linear-gradient(135deg,#2563eb,#7c3aed);
            display:flex;align-items:center;justify-content:center;
            font-size:2.8rem;color:#fff;
            box-shadow:0 0 0 16px rgba(37,99,235,.1),0 0 0 32px rgba(37,99,235,.05);
        }
        .h-orbit{
            position:absolute;top:50%;left:50%;
            border:1px solid rgba(255,255,255,.06);border-radius:50%;
            transform:translate(-50%,-50%);
        }
        .h-o1{width:190px;height:190px;animation:orb 13s linear infinite;}
        .h-o2{width:310px;height:310px;animation:orb 21s linear infinite reverse;}
        .h-o3{width:415px;height:415px;animation:orb 31s linear infinite;}
        @keyframes orb{to{transform:translate(-50%,-50%) rotate(360deg);}}
        .h-dot{position:absolute;width:10px;height:10px;border-radius:50%;top:-5px;left:calc(50% - 5px);}
        .h-chip{
            position:absolute;background:rgba(255,255,255,.07);
            border:1px solid rgba(255,255,255,.13);
            backdrop-filter:blur(12px);border-radius:14px;
            padding:10px 16px;display:flex;align-items:center;gap:10px;
            color:#fff;font-weight:600;font-size:.83rem;
            animation:chipFloat 3.5s ease-in-out infinite;
        }
        .h-chip i{font-size:1.2rem;}
        .hc1{top:6%;right:2%;animation-delay:0s;}
        .hc2{bottom:16%;right:-2%;animation-delay:1.2s;}
        .hc3{top:44%;left:-4%;animation-delay:2.4s;}
        @keyframes chipFloat{0%,100%{transform:translateY(0);}50%{transform:translateY(-9px);}}

        /* ── STATS ── */
        #stats{background:#fff;border-top:1px solid #f1f5f9;padding:60px 0;}
        .stat-item{text-align:center;padding:10px 24px;}
        .stat-num{
            font-size:2.5rem;font-weight:900;
            background:linear-gradient(135deg,#2563eb,#7c3aed);
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
        }
        .stat-lbl{color:#64748b;font-size:.88rem;margin-top:4px;}
        .stat-sep{width:1px;height:56px;background:#e2e8f0;align-self:center;}

        /* ── SECTIONS COMMON ── */
        section{padding:86px 0;}
        .s-badge{
            display:inline-block;background:#eff6ff;color:#2563eb;
            padding:4px 16px;border-radius:100px;font-size:.74rem;
            font-weight:800;letter-spacing:.07em;text-transform:uppercase;margin-bottom:14px;
        }
        .s-title{font-weight:900;font-size:clamp(1.75rem,3.5vw,2.5rem);color:#0f172a;margin-bottom:14px;}
        .s-sub{color:#64748b;font-size:.97rem;max-width:560px;line-height:1.75;}

        /* ── ABOUT ── */
        #about{background:#f8fafc;}
        .a-card{
            background:#fff;border-radius:20px;padding:30px 26px;
            box-shadow:0 4px 24px rgba(0,0,0,.055);height:100%;
            border-top:4px solid;transition:transform .22s;
        }
        .a-card:hover{transform:translateY(-5px);}
        .a-card.c1{border-color:#2563eb;} .a-card.c2{border-color:#7c3aed;}
        .a-card.c3{border-color:#059669;} .a-card.c4{border-color:#d97706;}
        .a-icon{width:50px;height:50px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.35rem;margin-bottom:14px;}
        .a-card.c1 .a-icon{background:#dbeafe;color:#2563eb;}
        .a-card.c2 .a-icon{background:#ede9fe;color:#7c3aed;}
        .a-card.c3 .a-icon{background:#d1fae5;color:#059669;}
        .a-card.c4 .a-icon{background:#fef3c7;color:#d97706;}
        .a-card h5{font-weight:700;font-size:1rem;margin-bottom:8px;}
        .a-card p{color:#64748b;font-size:.87rem;line-height:1.65;margin:0;}

        /* process */
        .proc-wrap{position:relative;}
        .proc-line{
            position:absolute;top:28px;left:calc(8.33% + 28px);right:calc(8.33% + 28px);
            height:2px;background:linear-gradient(90deg,#2563eb,#7c3aed);
            display:none;
        }
        @media(min-width:768px){.proc-line{display:block;}}
        .proc-step{text-align:center;padding:0 8px;}
        .proc-num{
            width:56px;height:56px;border-radius:50%;
            background:linear-gradient(135deg,#2563eb,#7c3aed);
            color:#fff;font-weight:900;font-size:1.1rem;
            display:flex;align-items:center;justify-content:center;
            margin:0 auto 14px;
            box-shadow:0 8px 20px rgba(37,99,235,.3);
        }
        .proc-step h6{font-weight:700;font-size:.88rem;margin-bottom:5px;}
        .proc-step p{color:#64748b;font-size:.78rem;margin:0;}

        /* ── COMPANIES ── */
        #companies{background:#fff;}
        .co-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:18px;}
        .co-tile{
            border:1px solid #e2e8f0;border-radius:18px;padding:24px 18px;text-align:center;
            transition:transform .22s,box-shadow .22s,border-color .22s;background:#fff;
        }
        .co-tile:hover{transform:translateY(-6px);box-shadow:0 16px 48px rgba(37,99,235,.11);border-color:#93c5fd;}
        .co-logo{
            width:58px;height:58px;border-radius:16px;
            background:linear-gradient(135deg,#eff6ff,#dbeafe);
            display:flex;align-items:center;justify-content:center;
            font-size:1.5rem;color:#2563eb;margin:0 auto 13px;
        }
        .co-tile h6{font-weight:700;font-size:.92rem;color:#0f172a;margin-bottom:4px;}
        .co-tile .co-loc{color:#94a3b8;font-size:.78rem;margin-bottom:9px;}
        .co-pkg{
            display:inline-block;background:#f0fdf4;color:#065f46;
            border:1px solid #a7f3d0;padding:3px 12px;
            border-radius:100px;font-size:.76rem;font-weight:700;
        }
        .co-desc{color:#64748b;font-size:.79rem;margin-top:9px;text-align:left;line-height:1.5;}

        /* ── DRIVES ── */
        #drives{background:#f8fafc;}
        .drive-row{
            background:#fff;border-radius:18px;
            border-left:5px solid #2563eb;
            padding:20px 22px;
            box-shadow:0 4px 20px rgba(0,0,0,.05);
            display:flex;align-items:center;gap:18px;
            transition:transform .2s;
        }
        .drive-row:hover{transform:translateX(5px);}
        .drive-row.st-ongoing{border-color:#d97706;}
        .drive-row.st-completed{border-color:#94a3b8;opacity:.75;}
        .d-date{
            min-width:60px;text-align:center;
            background:#eff6ff;border-radius:13px;padding:9px;flex-shrink:0;
        }
        .d-date .dd{font-size:1.45rem;font-weight:900;color:#2563eb;line-height:1;}
        .d-date .dm{font-size:.7rem;font-weight:700;color:#64748b;text-transform:uppercase;}
        .d-info h6{font-weight:700;font-size:.97rem;margin-bottom:5px;}
        .d-meta{font-size:.8rem;color:#64748b;display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
        .d-elig{font-size:.78rem;color:#475569;margin-top:5px;font-style:italic;}

        /* ── NOTICES ── */
        #notices{background:#fff;}
        .n-card{
            border:1px solid #e2e8f0;border-radius:16px;padding:22px 22px 20px;
            background:#fafbff;position:relative;overflow:hidden;
            transition:transform .2s,border-color .22s;
        }
        .n-card::before{
            content:'';position:absolute;top:0;left:0;width:4px;height:100%;
            background:linear-gradient(180deg,#2563eb,#7c3aed);
        }
        .n-card:hover{transform:translateY(-3px);border-color:#93c5fd;}
        .n-date{font-size:.73rem;color:#2563eb;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;}
        .n-title{font-weight:700;font-size:.95rem;color:#0f172a;margin-bottom:6px;}
        .n-body{color:#64748b;font-size:.84rem;line-height:1.6;margin:0;}

        /* ── CTA / CONTACT ── */
        #contact{
            background:linear-gradient(135deg,#1e3a8a 0%,#312e81 100%);
            padding:100px 0;position:relative;overflow:hidden;
        }
        #contact::before{
            content:'';position:absolute;inset:0;
            background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='3' fill='%23ffffff' fill-opacity='0.04'/%3E%3C/svg%3E");
        }
        .cta-z{position:relative;z-index:1;}
        .cta-title{font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;color:#fff;margin-bottom:14px;}
        .cta-sub{color:rgba(255,255,255,.6);max-width:470px;margin:0 auto 34px;font-size:1rem;line-height:1.7;}
        .btn-white{
            background:#fff;color:#1e3a8a;padding:13px 32px;border-radius:12px;
            font-weight:800;font-size:.95rem;text-decoration:none;
            display:inline-flex;align-items:center;gap:8px;
            box-shadow:0 8px 24px rgba(0,0,0,.2);transition:transform .2s;border:none;
        }
        .btn-white:hover{transform:translateY(-2px);color:#1e3a8a;}
        .btn-ghost-white{
            background:transparent;color:#fff;padding:13px 32px;border-radius:12px;
            font-weight:700;font-size:.95rem;text-decoration:none;
            display:inline-flex;align-items:center;gap:8px;
            border:2px solid rgba(255,255,255,.4);transition:border-color .2s,background .2s;
        }
        .btn-ghost-white:hover{border-color:#fff;background:rgba(255,255,255,.08);color:#fff;}
        .cta-contact{
            border-top:1px solid rgba(255,255,255,.1);
            margin-top:52px;padding-top:32px;
            display:flex;flex-wrap:wrap;justify-content:center;gap:28px;
        }
        .cta-contact span{color:rgba(255,255,255,.5);font-size:.85rem;}

        /* ── FOOTER ── */
        footer{background:#06080f;padding:38px 0 22px;}
        .f-brand{font-weight:800;font-size:1.08rem;color:#fff;}
        .f-brand em{color:#60a5fa;font-style:normal;}
        footer p,footer a{color:#475569;font-size:.83rem;}
        footer a:hover{color:#94a3b8;}
        footer a{text-decoration:none;}

        /* ── SCROLL TOP ── */
        #goTop{
            position:fixed;bottom:26px;right:26px;z-index:500;
            width:44px;height:44px;border-radius:12px;
            background:linear-gradient(135deg,#2563eb,#7c3aed);
            border:none;color:#fff;font-size:1.1rem;
            display:none;align-items:center;justify-content:center;
            cursor:pointer;box-shadow:0 8px 20px rgba(37,99,235,.4);
            transition:transform .2s;
        }
        #goTop.vis{display:flex;}
        #goTop:hover{transform:translateY(-3px);}
    </style>
</head>
<body>

<!-- ══ NAVBAR ══ -->
<nav class="navbar navbar-expand-lg pub-nav" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#hero">
            <div class="brand-dot"><i class="bi bi-mortarboard-fill"></i></div>
            T&amp;P Cell
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nLinks">
            <i class="bi bi-list text-white fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="nLinks">
            <ul class="navbar-nav mx-auto gap-1">
                <li><a href="#hero"      class="nav-link active">Home</a></li>
                <li><a href="#about"     class="nav-link">About</a></li>
                <li><a href="#companies" class="nav-link">Companies</a></li>
                <li><a href="#drives"    class="nav-link">Drives</a></li>
                <li><a href="#notices"   class="nav-link">Notices</a></li>
                <li><a href="#contact"   class="nav-link">Contact</a></li>
            </ul>
            <div class="d-flex gap-2 mt-3 mt-lg-0">
                <a href="login.php" class="nav-link btn-nav-login"><i class="bi bi-box-arrow-in-right me-1"></i>Login</a>
                <a href="login.php?tab=register" class="nav-link btn-nav-reg"><i class="bi bi-person-plus me-1"></i>Register</a>
            </div>
        </div>
    </div>
</nav>

<!-- ══ HERO ══ -->
<section id="hero">
    <div class="hero-grid"></div>
    <div class="hero-glow"></div>
    <div class="container position-relative py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge"><i class="bi bi-lightning-charge-fill"></i> Campus Placement 2024–25</div>
                <h1 class="hero-title">Your Dream Career<br><span class="grad-text">Starts Right Here</span></h1>
                <p class="hero-sub">Connect with top companies, track live placement drives, upload your resume and launch your professional journey — all in one portal.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="login.php?tab=register" class="btn-primary-hero"><i class="bi bi-person-plus"></i> Get Started Free</a>
                    <a href="#companies" class="btn-ghost-hero"><i class="bi bi-building"></i> View Companies</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="h-visual">
                    <div class="h-orbit h-o1"><div class="h-dot" style="background:#60a5fa;"></div></div>
                    <div class="h-orbit h-o2"><div class="h-dot" style="background:#a78bfa;"></div></div>
                    <div class="h-orbit h-o3"><div class="h-dot" style="background:#34d399;"></div></div>
                    <div class="h-center"><i class="bi bi-mortarboard-fill"></i></div>
                    <div class="h-chip hc1"><i class="bi bi-building-fill" style="color:#60a5fa"></i><?= $stats['companies'] ?>+ Companies</div>
                    <div class="h-chip hc2"><i class="bi bi-trophy-fill" style="color:#fbbf24"></i><?= $stats['placed'] ?>+ Placed</div>
                    <div class="h-chip hc3"><i class="bi bi-people-fill" style="color:#34d399"></i><?= $stats['students'] ?> Students</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══ STATS ══ -->
<section id="stats" style="padding:60px 0;background:#fff;border-top:1px solid #f1f5f9;">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center align-items-center">
            <div class="stat-item"><div class="stat-num" data-to="<?= $stats['companies'] ?>"><?= $stats['companies'] ?>+</div><div class="stat-lbl">Companies Visited</div></div>
            <div class="stat-sep d-none d-md-block"></div>
            <div class="stat-item"><div class="stat-num" data-to="<?= $stats['placed'] ?>"><?= $stats['placed'] ?>+</div><div class="stat-lbl">Students Placed</div></div>
            <div class="stat-sep d-none d-md-block"></div>
            <div class="stat-item"><div class="stat-num" data-to="<?= $stats['drives'] ?>"><?= $stats['drives'] ?>+</div><div class="stat-lbl">Drives Conducted</div></div>
            <div class="stat-sep d-none d-md-block"></div>
            <div class="stat-item"><div class="stat-num">4.5 LPA</div><div class="stat-lbl">Highest Package</div></div>
            <div class="stat-sep d-none d-md-block"></div>
            <div class="stat-item"><div class="stat-num">100%</div><div class="stat-lbl">Support Provided</div></div>
        </div>
    </div>
</section>

<!-- ══ ABOUT ══ -->
<section id="about" style="background:#f8fafc;">
    <div class="container">
        <!-- About header -->
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-5">
                <div class="s-badge">About Us</div>
                <h2 class="s-title">Training &amp; Placement Cell</h2>
                <p class="s-sub">The T&amp;P Cell is the bridge between our talented students and leading industries worldwide. We provide career guidance, organize placement drives, and ensure every student is industry-ready.</p>
                <a href="login.php" class="btn-primary-hero mt-4" style="width:fit-content;"><i class="bi bi-box-arrow-in-right"></i> Login / Register</a>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <?php $cards=[['c1','briefcase-fill','Career Guidance','One-on-one sessions with mentors to map your career path.'],['c2','file-earmark-check-fill','Resume Review','Expert review and formatting of resumes for maximum impact.'],['c3','people-fill','Campus Drives','Top companies come directly to campus for recruitment.'],['c4','mortarboard-fill','Skill Training','Aptitude, GD, and technical interview prep workshops.']];foreach($cards as [$cls,$ico,$t,$d]):?>
                    <div class="col-6"><div class="a-card <?=$cls?>"><div class="a-icon"><i class="bi bi-<?=$ico?>"></i></div><h5><?=$t?></h5><p><?=$d?></p></div></div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
        <!-- Process -->
        <div class="text-center mb-5">
            <div class="s-badge">How It Works</div>
            <h2 class="s-title">Your Placement Journey in 6 Steps</h2>
        </div>
        <div class="proc-wrap">
            <div class="proc-line"></div>
            <div class="row g-4">
                <?php $steps=[['Register','Create your student account.'],['Get Approved','Admin verifies your profile.'],['Upload Resume','Add your updated CV.'],['Browse Drives','See upcoming company visits.'],['Apply','Submit applications easily.'],['Get Placed!','Celebrate your success!']];foreach($steps as $i=>[$t,$d]):?>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="proc-step">
                        <div class="proc-num"><?=$i+1?></div>
                        <h6><?=$t?></h6>
                        <p><?=$d?></p>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</section>

<!-- ══ COMPANIES ══ -->
<section id="companies" style="background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="s-badge">Our Recruiters</div>
            <h2 class="s-title">Companies That Hire From Here</h2>
            <p class="s-sub mx-auto">Leading organizations that regularly visit our campus for placement drives.</p>
        </div>
        <?php if(empty($companies)):?>
            <div class="text-center text-muted py-4">No companies listed yet.</div>
        <?php else:?>
        <div class="co-grid">
            <?php foreach($companies as $c):?>
            <div class="co-tile">
                <div class="co-logo"><i class="bi bi-building-fill"></i></div>
                <h6><?=htmlspecialchars($c['company_name'])?></h6>
                <div class="co-loc"><i class="bi bi-geo-alt me-1"></i><?=htmlspecialchars($c['location']??'N/A')?></div>
                <span class="co-pkg"><i class="bi bi-currency-rupee"></i><?=htmlspecialchars($c['package']??'N/A')?></span>
                <?php if($c['description']):?><div class="co-desc"><?=htmlspecialchars(substr($c['description'],0,75))?><?=strlen($c['description'])>75?'...':''?></div><?php endif;?>
            </div>
            <?php endforeach;?>
        </div>
        <?php endif;?>
    </div>
</section>

<!-- ══ DRIVES ══ -->
<section id="drives" style="background:#f8fafc;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="s-badge">Placement Drives</div>
            <h2 class="s-title">Upcoming &amp; Recent Drives</h2>
        </div>
        <?php if(empty($drives)):?>
            <div class="text-center text-muted py-4"><i class="bi bi-calendar-x d-block fs-2 mb-2"></i>No drives scheduled yet.</div>
        <?php else:?>
        <div class="row g-3">
            <?php foreach($drives as $d):?>
            <div class="col-md-6">
                <div class="drive-row st-<?=$d['status']?>">
                    <div class="d-date">
                        <div class="dd"><?=date('d',strtotime($d['drive_date']))?></div>
                        <div class="dm"><?=date('M Y',strtotime($d['drive_date']))?></div>
                    </div>
                    <div class="d-info flex-grow-1">
                        <h6><?=htmlspecialchars($d['company_name'])?></h6>
                        <div class="d-meta">
                            <span><i class="bi bi-geo-alt me-1"></i><?=htmlspecialchars($d['location']??'N/A')?></span>
                            <span><i class="bi bi-currency-rupee me-1"></i><?=htmlspecialchars($d['package']??'N/A')?></span>
                            <span class="badge bg-<?=$d['status']==='upcoming'?'success':($d['status']==='ongoing'?'warning':'secondary')?>"><?=ucfirst($d['status'])?></span>
                        </div>
                        <?php if($d['eligibility']):?><div class="d-elig"><i class="bi bi-info-circle me-1"></i><?=htmlspecialchars($d['eligibility'])?></div><?php endif;?>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        <?php endif;?>
        <div class="text-center mt-5">
            <a href="login.php" class="btn-primary-hero"><i class="bi bi-send"></i> Login to Apply for Drives</a>
        </div>
    </div>
</section>

<!-- ══ NOTICES ══ -->
<section id="notices" style="background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="s-badge">Notice Board</div>
            <h2 class="s-title">Latest Announcements</h2>
        </div>
        <?php if(empty($notices)):?>
            <div class="text-center text-muted py-4">No notices at this time.</div>
        <?php else:?>
        <div class="row g-4">
            <?php foreach($notices as $n):?>
            <div class="col-md-6 col-lg-4">
                <div class="n-card">
                    <div class="n-date"><i class="bi bi-calendar3 me-1"></i><?=date('d M Y',strtotime($n['created_at']))?></div>
                    <div class="n-title"><?=htmlspecialchars($n['title'])?></div>
                    <?php if($n['content']):?><p class="n-body"><?=htmlspecialchars(substr($n['content'],0,130))?><?=strlen($n['content'])>130?'...':''?></p><?php endif;?>
                </div>
            </div>
            <?php endforeach;?>
        </div>
        <?php endif;?>
    </div>
</section>

<!-- ══ CONTACT / CTA ══ -->
<section id="contact">
    <div class="container text-center cta-z">
        <div class="s-badge" style="background:rgba(255,255,255,.1);color:#93c5fd;border:1px solid rgba(255,255,255,.15);">Get In Touch</div>
        <h2 class="cta-title mt-3">Ready to Launch Your Career?</h2>
        <p class="cta-sub">Register today, upload your resume, and start applying to top companies visiting our campus.</p>
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            <a href="login.php?tab=register" class="btn-white"><i class="bi bi-person-plus"></i> Register Now</a>
            <a href="login.php"              class="btn-ghost-white"><i class="bi bi-box-arrow-in-right"></i> Login to Portal</a>
        </div>
        <div class="cta-contact">
            <span><i class="bi bi-envelope me-2"></i>placement@college.edu</span>
            <span><i class="bi bi-telephone me-2"></i>+91-XXXXX-XXXXX</span>
            <span><i class="bi bi-geo-alt me-2"></i>Placement Cell, Main Building</span>
            <span><i class="bi bi-clock me-2"></i>Mon–Fri, 9 AM – 5 PM</span>
        </div>
    </div>
</section>

<!-- ══ FOOTER ══ -->
<footer>
    <div class="container">
        <div class="row align-items-center gy-3">
            <div class="col-md-5">
                <div class="f-brand"><i class="bi bi-mortarboard-fill me-2"></i>T&amp;P <em>Cell</em></div>
                <p class="mt-1">Training &amp; Placement Cell — Official Student Portal</p>
            </div>
            <div class="col-md-7 text-md-end">
                <div class="d-flex justify-content-md-end flex-wrap gap-3 mb-2">
                    <a href="#hero">Home</a><a href="#about">About</a>
                    <a href="#companies">Companies</a><a href="#drives">Drives</a>
                    <a href="#notices">Notices</a><a href="login.php">Login</a>
                </div>
                <p>&copy; <?=date('Y')?> All rights reserved. Training &amp; Placement Cell.</p>
            </div>
        </div>
    </div>
</footer>

<button id="goTop" onclick="window.scrollTo({top:0,behavior:'smooth'})"><i class="bi bi-arrow-up"></i></button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const nav = document.getElementById('mainNav');
const goTop = document.getElementById('goTop');
const sections = document.querySelectorAll('section[id]');
const links = document.querySelectorAll('.pub-nav .nav-link[href^="#"]');

window.addEventListener('scroll', () => {
    const y = window.scrollY;
    nav.classList.toggle('scrolled', y > 50);
    goTop.classList.toggle('vis', y > 400);
    // active link
    sections.forEach(s => {
        if (y >= s.offsetTop - 120 && y < s.offsetTop + s.offsetHeight - 120) {
            links.forEach(l => l.classList.remove('active'));
            const a = document.querySelector(`.pub-nav .nav-link[href="#${s.id}"]`);
            if (a) a.classList.add('active');
        }
    });
});

// Counter animation
const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (!e.isIntersecting) return;
        e.target.querySelectorAll('[data-to]').forEach(el => {
            const end = +el.dataset.to, suffix = el.textContent.replace(/[0-9]/g,'');
            let cur = 0, step = end / 45;
            const t = setInterval(() => {
                cur = Math.min(cur + step, end);
                el.textContent = Math.floor(cur) + (suffix || '+');
                if (cur >= end) clearInterval(t);
            }, 28);
        });
        obs.disconnect();
    });
}, {threshold: 0.4});
const statsSection = document.getElementById('stats');
if (statsSection) obs.observe(statsSection);
</script>
</body>
</html>
