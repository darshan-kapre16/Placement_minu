<?php
/**
 * Smart Unified Login + Register Page
 * placement_m/public/login.php
 *
 * Single form — tries admin first (by username), then student (by email).
 * Also embeds student registration.
 */

session_start();
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/app/models/Admin.php';
require_once dirname(__DIR__) . '/app/models/Student.php';

/* ── handle register POST ── */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_action'] ?? '') === 'register') {
    $data = [
        'name'     => trim($_POST['name']     ?? ''),
        'email'    => trim($_POST['email']    ?? ''),
        'password' => $_POST['password']      ?? '',
        'phone'    => trim($_POST['phone']    ?? ''),
        'branch'   => trim($_POST['branch']   ?? ''),
        'year'     => trim($_POST['year']     ?? ''),
        'cgpa'     => (float)($_POST['cgpa']  ?? 0),
    ];
    if (!$data['name'] || !$data['email'] || !$data['password']) {
        $regError = 'Name, email and password are required.';
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $regError = 'Invalid email address.';
    } else {
        $sm = new Student();
        $res = $sm->register($data);
        if ($res['success']) {
            $regSuccess = 'Account created! You can now login once admin approves your profile.';
        } else {
            $regError = $res['message'];
        }
    }
}

/* ── handle unified login POST ── */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_action'] ?? '') === 'login') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password   = $_POST['password'] ?? '';
    $loginError = '';

    if (!$identifier || !$password) {
        $loginError = 'Please enter your username/email and password.';
    } else {
        // Try admin first (username match)
        $adminModel   = new Admin();
        $studentModel = new Student();
        $admin = $adminModel->login($identifier, $password);

        if ($admin) {
            // ✅ Admin login success
            session_regenerate_id(true);
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_user'] = $admin['username'];
            header('Location: ' . BASE_URL . 'index.php?page=admin_dashboard');
            exit;
        }

        // Try student (email match)
        $student = $studentModel->login($identifier, $password);
        if ($student) {
            // ✅ Student login success
            session_regenerate_id(true);
            $_SESSION['student_id']   = $student['id'];
            $_SESSION['student_name'] = $student['name'];
            header('Location: ' . BASE_URL . 'index.php?page=student_dashboard');
            exit;
        }

        // ❌ Neither matched
        $loginError = 'Invalid credentials. Please check your username/email and password.';
    }
}

$loginError  = $loginError  ?? ($_SESSION['login_error']   ?? '');
$regError    = $regError    ?? ($_SESSION['register_error'] ?? '');
$regSuccess  = $regSuccess  ?? ($_SESSION['register_success'] ?? '');
unset($_SESSION['login_error'], $_SESSION['register_error'], $_SESSION['register_success'],
      $_SESSION['admin_login_error'], $_SESSION['student_login_error']);

// Which panel to show: login or register
$view = isset($regError) && $regError ? 'register' : (isset($regSuccess) && $regSuccess ? 'login' : 'login');
if ($_GET['view'] ?? '' === 'register') $view = 'register';

// Load stats for left panel
require_once dirname(__DIR__) . '/app/models/Company.php';
try { $stats = (new Company())->getPublicStats(); } catch (Exception $e) { $stats = ['companies'=>0,'placed'=>0,'drives'=>0,'students'=>0]; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portal Login | T&P Cell</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════
   RESET & BASE
═══════════════════════════════════════════ */
*{box-sizing:border-box;margin:0;padding:0;}
html,body{height:100%;font-family:'Plus Jakarta Sans',sans-serif;}
body{display:flex;min-height:100vh;overflow:hidden;}

/* ═══════════════════════════════════════════
   LEFT PANEL — Info / Branding
═══════════════════════════════════════════ */
.left-panel{
    width:52%;min-height:100vh;
    background: #060b1a;
    position:relative;overflow:hidden;
    display:flex;flex-direction:column;
    padding:36px 48px;
}
/* Animated gradient mesh background */
.lp-bg{
    position:absolute;inset:0;z-index:0;
    background:
        radial-gradient(ellipse 60% 50% at 20% 20%, rgba(37,99,235,.22) 0%, transparent 60%),
        radial-gradient(ellipse 50% 60% at 80% 80%, rgba(124,58,237,.18) 0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 60% 30%, rgba(6,182,212,.1) 0%, transparent 55%),
        #060b1a;
    animation: meshShift 12s ease-in-out infinite alternate;
}
@keyframes meshShift{
    0%{background-position:0% 0%,100% 100%,60% 30%;}
    100%{background-position:10% 10%,90% 90%,65% 35%;}
}
/* Grid overlay */
.lp-grid{
    position:absolute;inset:0;z-index:1;
    background-image:
        linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
    background-size:50px 50px;
    mask-image:radial-gradient(ellipse 80% 80% at 40% 40%,#000 30%,transparent 80%);
}
/* Floating orbs */
.orb{position:absolute;border-radius:50%;filter:blur(60px);pointer-events:none;z-index:1;}
.orb-1{width:300px;height:300px;background:rgba(37,99,235,.15);top:-80px;left:-60px;animation:orbFloat 8s ease-in-out infinite;}
.orb-2{width:250px;height:250px;background:rgba(124,58,237,.12);bottom:60px;right:-40px;animation:orbFloat 11s ease-in-out infinite reverse;}
.orb-3{width:180px;height:180px;background:rgba(6,182,212,.1);top:50%;left:40%;animation:orbFloat 9s ease-in-out infinite 2s;}
@keyframes orbFloat{0%,100%{transform:translate(0,0);}50%{transform:translate(20px,-20px);}}

/* Content */
.lp-inner{position:relative;z-index:10;flex:1;display:flex;flex-direction:column;}
.lp-logo{
    display:flex;align-items:center;gap:12px;
    text-decoration:none;margin-bottom:auto;padding-bottom:40px;
}
.logo-box{
    width:44px;height:44px;border-radius:13px;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    display:flex;align-items:center;justify-content:center;
    font-size:1.25rem;color:#fff;
    box-shadow:0 8px 24px rgba(37,99,235,.4);
}
.logo-text{color:#fff;font-weight:800;font-size:1.1rem;line-height:1.1;}
.logo-sub{color:rgba(255,255,255,.4);font-size:.72rem;display:block;}

/* Central hero content */
.lp-hero{flex:1;display:flex;flex-direction:column;justify-content:center;}
.lp-badge{
    display:inline-flex;align-items:center;gap:7px;
    background:rgba(37,99,235,.15);border:1px solid rgba(37,99,235,.35);
    color:#93c5fd;padding:5px 14px;border-radius:100px;
    font-size:.74rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;
    margin-bottom:22px;width:fit-content;
}
.lp-title{
    font-size:clamp(2rem,3.2vw,2.8rem);
    font-weight:900;color:#fff;line-height:1.12;margin-bottom:18px;
}
.lp-title .hi{
    background:linear-gradient(90deg,#60a5fa,#a78bfa,#f472b6);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.lp-desc{color:rgba(255,255,255,.55);font-size:.95rem;line-height:1.75;max-width:400px;margin-bottom:36px;}

/* Stat chips */
.stat-chips{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:40px;}
.chip{
    display:flex;align-items:center;gap:8px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    border-radius:12px;padding:10px 16px;
    transition:background .2s;
}
.chip:hover{background:rgba(255,255,255,.1);}
.chip-icon{
    width:34px;height:34px;border-radius:9px;
    display:flex;align-items:center;justify-content:center;font-size:.95rem;flex-shrink:0;
}
.chip-icon.blue{background:rgba(37,99,235,.25);color:#60a5fa;}
.chip-icon.purple{background:rgba(124,58,237,.25);color:#c4b5fd;}
.chip-icon.green{background:rgba(5,150,105,.25);color:#6ee7b7;}
.chip-icon.amber{background:rgba(217,119,6,.25);color:#fcd34d;}
.chip-val{font-weight:800;font-size:1rem;color:#fff;line-height:1;}
.chip-lbl{font-size:.72rem;color:rgba(255,255,255,.45);margin-top:1px;}

/* Role cards */
.role-cards{display:flex;gap:10px;}
.role-card{
    flex:1;border-radius:14px;padding:14px 16px;
    border:1px solid rgba(255,255,255,.08);
    background:rgba(255,255,255,.04);
    display:flex;flex-direction:column;gap:4px;
}
.rc-icon{font-size:1.3rem;margin-bottom:6px;}
.rc-title{font-weight:700;font-size:.82rem;color:#fff;}
.rc-desc{font-size:.72rem;color:rgba(255,255,255,.4);line-height:1.4;}

/* ═══════════════════════════════════════════
   RIGHT PANEL — Form
═══════════════════════════════════════════ */
.right-panel{
    width:48%;min-height:100vh;
    background:#fff;
    display:flex;flex-direction:column;
    overflow-y:auto;
}
.rp-inner{
    flex:1;display:flex;flex-direction:column;
    justify-content:center;padding:48px 52px;
    max-width:520px;width:100%;margin:0 auto;
}

/* View toggle */
.view-toggle{
    display:flex;background:#f1f5f9;
    border-radius:12px;padding:4px;margin-bottom:32px;gap:3px;
}
.vt-btn{
    flex:1;text-align:center;padding:10px 8px;border-radius:9px;
    font-size:.83rem;font-weight:700;color:#64748b;
    cursor:pointer;border:none;background:none;
    transition:all .2s;display:flex;align-items:center;justify-content:center;gap:6px;
}
.vt-btn:hover{color:#1e293b;}
.vt-btn.active{background:#fff;color:#2563eb;box-shadow:0 2px 12px rgba(0,0,0,.08);}

/* Form heading */
.form-heading{margin-bottom:28px;}
.form-heading h2{font-weight:900;font-size:1.65rem;color:#0f172a;margin-bottom:6px;}
.form-heading p{color:#64748b;font-size:.9rem;margin:0;}

/* Input styles */
.fi-label{display:block;font-size:.8rem;font-weight:700;color:#374151;margin-bottom:6px;}
.fi-wrap{position:relative;}
.fi-icon{
    position:absolute;left:14px;top:50%;transform:translateY(-50%);
    color:#9ca3af;font-size:1rem;pointer-events:none;
}
.fi-input{
    width:100%;border:2px solid #e5e7eb;border-radius:11px;
    padding:12px 14px 12px 42px;
    font-size:.92rem;font-family:inherit;color:#0f172a;
    background:#fff;transition:border-color .2s,box-shadow .2s;outline:none;
}
.fi-input:focus{border-color:#2563eb;box-shadow:0 0 0 4px rgba(37,99,235,.1);}
.fi-input::placeholder{color:#d1d5db;}
.fi-eye{
    position:absolute;right:14px;top:50%;transform:translateY(-50%);
    background:none;border:none;color:#9ca3af;font-size:1rem;
    cursor:pointer;padding:4px;transition:color .2s;
}
.fi-eye:hover{color:#374151;}
.fi-select{
    width:100%;border:2px solid #e5e7eb;border-radius:11px;
    padding:12px 14px 12px 42px;
    font-size:.92rem;font-family:inherit;color:#0f172a;
    background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 16 16'%3E%3Cpath fill='%239ca3af' d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right 14px center;
    appearance:none;transition:border-color .2s;outline:none;cursor:pointer;
}
.fi-select:focus{border-color:#2563eb;box-shadow:0 0 0 4px rgba(37,99,235,.1);}

/* Hint below identifier field */
.id-hint{
    margin-top:6px;font-size:.76rem;color:#94a3b8;
    display:flex;align-items:center;gap:4px;
}

/* Role detector badge */
.role-detected{
    display:none;align-items:center;gap:8px;
    padding:9px 14px;border-radius:9px;margin-top:8px;
    font-size:.8rem;font-weight:600;
}
.role-detected.admin {background:#fef2f2;border:1px solid #fecaca;color:#dc2626;}
.role-detected.student{background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;}
.role-detected.show{display:flex;}

/* Submit button */
.btn-login{
    width:100%;padding:14px;border:none;border-radius:12px;
    background:linear-gradient(135deg,#2563eb,#7c3aed);
    color:#fff;font-weight:800;font-size:.97rem;font-family:inherit;
    cursor:pointer;transition:transform .18s,box-shadow .18s;
    box-shadow:0 6px 20px rgba(37,99,235,.35);
    display:flex;align-items:center;justify-content:center;gap:8px;
    position:relative;overflow:hidden;
}
.btn-login::before{
    content:'';position:absolute;inset:0;
    background:linear-gradient(135deg,rgba(255,255,255,.1),transparent);
    opacity:0;transition:opacity .2s;
}
.btn-login:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(37,99,235,.45);}
.btn-login:hover::before{opacity:1;}
.btn-login:active{transform:translateY(0);}
.btn-register{
    background:linear-gradient(135deg,#059669,#0891b2);
    box-shadow:0 6px 20px rgba(5,150,105,.3);
}
.btn-register:hover{box-shadow:0 10px 28px rgba(5,150,105,.4);}

/* Alerts */
.a-err{
    background:#fef2f2;border:1px solid #fecaca;
    border-radius:10px;padding:12px 16px;
    font-size:.84rem;color:#dc2626;margin-bottom:20px;
    display:flex;align-items:flex-start;gap:10px;
}
.a-ok{
    background:#f0fdf4;border:1px solid #bbf7d0;
    border-radius:10px;padding:12px 16px;
    font-size:.84rem;color:#16a34a;margin-bottom:20px;
    display:flex;align-items:flex-start;gap:10px;
}

/* Divider */
.or-sep{
    display:flex;align-items:center;gap:12px;
    margin:20px 0;color:#d1d5db;font-size:.8rem;
}
.or-sep::before,.or-sep::after{content:'';flex:1;height:1px;background:#f1f5f9;}

/* Features list (login page bottom) */
.feature-list{
    margin-top:24px;display:grid;grid-template-columns:1fr 1fr;gap:10px;
}
.feat{
    display:flex;align-items:flex-start;gap:8px;
    background:#f8fafc;border-radius:10px;padding:10px 12px;
}
.feat i{font-size:1rem;margin-top:1px;flex-shrink:0;}
.feat span{font-size:.78rem;color:#475569;line-height:1.4;}

/* Bottom link */
.rp-footer{margin-top:28px;text-align:center;font-size:.83rem;color:#94a3b8;}
.rp-footer a{color:#2563eb;font-weight:700;text-decoration:none;}
.rp-footer a:hover{text-decoration:underline;}

/* Back link top */
.rp-top{margin-bottom:32px;display:flex;align-items:center;justify-content:space-between;}
.back-link{
    display:flex;align-items:center;gap:6px;
    color:#64748b;text-decoration:none;font-size:.83rem;font-weight:600;
    transition:color .2s;
}
.back-link:hover{color:#2563eb;}

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media(max-width:900px){
    .left-panel{display:none;}
    .right-panel{width:100%;}
    .rp-inner{padding:36px 28px;}
}
@media(max-width:480px){
    .rp-inner{padding:28px 20px;}
}
</style>
</head>
<body>

<!-- ══════════════════════════════════════
     LEFT PANEL
══════════════════════════════════════ -->
<div class="left-panel">
    <div class="lp-bg"></div>
    <div class="lp-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="lp-inner">
        <!-- Logo -->
        <a href="index.php?page=home" class="lp-logo">
            <div class="logo-box"><i class="bi bi-mortarboard-fill"></i></div>
            <div>
                <div class="logo-text">T&amp;P Cell Portal</div>
                <span class="logo-sub">Training &amp; Placement Cell</span>
            </div>
        </a>

        <!-- Hero -->
        <div class="lp-hero">
            <div class="lp-badge"><i class="bi bi-lightning-charge-fill"></i> Campus Placements 2024–25</div>
            <h1 class="lp-title">One Portal.<br><span class="hi">Every Opportunity.</span></h1>
            <p class="lp-desc">Connect with top recruiters, track placement drives in real-time, and manage your entire campus placement journey from a single, powerful dashboard.</p>

            <!-- Stats -->
            <div class="stat-chips">
                <div class="chip">
                    <div class="chip-icon blue"><i class="bi bi-building-fill"></i></div>
                    <div><div class="chip-val"><?= $stats['companies'] ?? '6' ?>+</div><div class="chip-lbl">Companies</div></div>
                </div>
                <div class="chip">
                    <div class="chip-icon purple"><i class="bi bi-trophy-fill"></i></div>
                    <div><div class="chip-val"><?= $stats['placed'] ?? '0' ?>+</div><div class="chip-lbl">Placed</div></div>
                </div>
                <div class="chip">
                    <div class="chip-icon green"><i class="bi bi-calendar-check-fill"></i></div>
                    <div><div class="chip-val"><?= $stats['drives'] ?? '3' ?>+</div><div class="chip-lbl">Drives</div></div>
                </div>
                <div class="chip">
                    <div class="chip-icon amber"><i class="bi bi-people-fill"></i></div>
                    <div><div class="chip-val"><?= $stats['students'] ?? '0' ?>+</div><div class="chip-lbl">Students</div></div>
                </div>
            </div>

            <!-- Who can login -->
            <div class="role-cards">
                <div class="role-card">
                    <div class="rc-icon">🎓</div>
                    <div class="rc-title">Students</div>
                    <div class="rc-desc">Login with your registered email address</div>
                </div>
                <div class="role-card">
                    <div class="rc-icon">🛡️</div>
                    <div class="rc-title">Admins</div>
                    <div class="rc-desc">Login with your admin username</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════
     RIGHT PANEL
══════════════════════════════════════ -->
<div class="right-panel">
    <div class="rp-inner">

        <!-- Top: back link -->
        <div class="rp-top">
            <a href="index.php?page=home" class="back-link">
                <i class="bi bi-arrow-left-circle-fill"></i> Back to Website
            </a>
            <span style="font-size:.78rem;color:#94a3b8;">v2.0</span>
        </div>

        <!-- View toggle -->
        <div class="view-toggle">
            <button class="vt-btn <?= $view==='login'?'active':'' ?>" id="btnLogin" onclick="showView('login')">
                <i class="bi bi-box-arrow-in-right"></i> Sign In
            </button>
            <button class="vt-btn <?= $view==='register'?'active':'' ?>" id="btnReg" onclick="showView('register')">
                <i class="bi bi-person-plus-fill"></i> Create Account
            </button>
        </div>

        <!-- ══════════════
             LOGIN VIEW
        ══════════════ -->
        <div id="view-login" style="<?= $view==='login'?'':'display:none' ?>">
            <div class="form-heading">
                <h2>Welcome Back 👋</h2>
                <p>Enter your credentials — we'll detect your role automatically.</p>
            </div>

            <?php if(!empty($loginError)):?>
            <div class="a-err"><i class="bi bi-exclamation-triangle-fill fs-5"></i><div><strong>Login Failed</strong><br><?= htmlspecialchars($loginError) ?></div></div>
            <?php endif;?>
            <?php if(!empty($regSuccess)):?>
            <div class="a-ok"><i class="bi bi-check-circle-fill fs-5"></i><div><strong>Account Created!</strong><br><?= htmlspecialchars($regSuccess) ?></div></div>
            <?php endif;?>

            <form method="POST" action="login.php" autocomplete="on">
                <input type="hidden" name="_action" value="login">

                <!-- Identifier -->
                <div class="mb-3">
                    <label class="fi-label">Username or Email Address</label>
                    <div class="fi-wrap">
                        <i class="bi bi-person-fill fi-icon"></i>
                        <input type="text" name="identifier" id="identifier" class="fi-input"
                               placeholder="admin username  or  student@email.com"
                               autocomplete="username" oninput="detectRole(this.value)"
                               value="<?= htmlspecialchars($_POST['identifier'] ?? '') ?>" required>
                    </div>
                    <div class="id-hint"><i class="bi bi-info-circle"></i> Admins use their username &nbsp;·&nbsp; Students use their email</div>
                    <!-- Role detection indicator -->
                    <div class="role-detected admin" id="roleAdmin">
                        <i class="bi bi-shield-fill-check fs-5"></i>
                        <div><strong>Admin Detected</strong> — You'll be redirected to the Admin Dashboard</div>
                    </div>
                    <div class="role-detected student" id="roleStudent">
                        <i class="bi bi-person-check-fill fs-5"></i>
                        <div><strong>Student Login</strong> — You'll be redirected to the Student Portal</div>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="fi-label">Password</label>
                    <div class="fi-wrap">
                        <i class="bi bi-lock-fill fi-icon"></i>
                        <input type="password" name="password" id="lpass" class="fi-input"
                               placeholder="Enter your password" autocomplete="current-password" required>
                        <button type="button" class="fi-eye" onclick="toggleEye('lpass',this)"><i class="bi bi-eye"></i></button>
                    </div>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <i class="bi bi-box-arrow-in-right" id="loginIcon"></i>
                    <span id="loginText">Sign In to Portal</span>
                </button>
            </form>

            <!-- Features -->
            <div class="feature-list">
                <div class="feat"><i class="bi bi-shield-check text-primary"></i><span>Secure session-based authentication</span></div>
                <div class="feat"><i class="bi bi-lightning-charge text-warning"></i><span>Instant role detection & redirect</span></div>
                <div class="feat"><i class="bi bi-building text-success"></i><span>Access to all company drives</span></div>
                <div class="feat"><i class="bi bi-bell text-info"></i><span>Real-time placement notices</span></div>
            </div>

            <div class="rp-footer">
                New student? <a href="#" onclick="showView('register');return false;">Create an account</a>
            </div>
        </div>

        <!-- ══════════════════
             REGISTER VIEW
        ══════════════════ -->
        <div id="view-register" style="<?= $view==='register'?'':'display:none' ?>">
            <div class="form-heading">
                <h2>Create Account ✨</h2>
                <p>Register as a student — admin will approve your profile.</p>
            </div>

            <?php if(!empty($regError)):?>
            <div class="a-err"><i class="bi bi-exclamation-triangle-fill fs-5"></i><div><strong>Registration Failed</strong><br><?= htmlspecialchars($regError) ?></div></div>
            <?php endif;?>

            <form method="POST" action="login.php" id="regForm" autocomplete="off">
                <input type="hidden" name="_action" value="register">

                <div class="row g-3">
                    <div class="col-12">
                        <label class="fi-label">Full Name *</label>
                        <div class="fi-wrap">
                            <i class="bi bi-person-fill fi-icon"></i>
                            <input type="text" name="name" class="fi-input" placeholder="Your full name" required>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <label class="fi-label">Email Address *</label>
                        <div class="fi-wrap">
                            <i class="bi bi-envelope-fill fi-icon"></i>
                            <input type="email" name="email" class="fi-input" placeholder="student@college.edu" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="fi-label">Phone</label>
                        <div class="fi-wrap">
                            <i class="bi bi-phone-fill fi-icon"></i>
                            <input type="tel" name="phone" class="fi-input" placeholder="10-digit">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="fi-label">Branch</label>
                        <div class="fi-wrap">
                            <i class="bi bi-diagram-3-fill fi-icon"></i>
                            <select name="branch" class="fi-select">
                                <option value="">-- Branch --</option>
                                <?php foreach(['CSE','IT','ECE','EEE','ME','CE','AIDS','AIML','DS'] as $b):?>
                                <option><?=$b?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="fi-label">Year</label>
                        <div class="fi-wrap">
                            <i class="bi bi-calendar3 fi-icon"></i>
                            <select name="year" class="fi-select">
                                <option value="">Year</option>
                                <option>1st Year</option><option>2nd Year</option>
                                <option>3rd Year</option><option selected>Final Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="fi-label">CGPA</label>
                        <div class="fi-wrap">
                            <i class="bi bi-star-fill fi-icon"></i>
                            <input type="number" name="cgpa" class="fi-input" style="padding-left:42px" step="0.01" min="0" max="10" placeholder="7.5">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fi-label">Password *</label>
                        <div class="fi-wrap">
                            <i class="bi bi-lock-fill fi-icon"></i>
                            <input type="password" name="password" id="rp1" class="fi-input" placeholder="Min 6 chars" required minlength="6">
                            <button type="button" class="fi-eye" onclick="toggleEye('rp1',this)"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fi-label">Confirm Password *</label>
                        <div class="fi-wrap">
                            <i class="bi bi-lock-fill fi-icon"></i>
                            <input type="password" id="rp2" class="fi-input" placeholder="Re-enter" required>
                            <button type="button" class="fi-eye" onclick="toggleEye('rp2',this)"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-12 mt-1">
                        <button type="submit" class="btn-login btn-register">
                            <i class="bi bi-person-plus-fill"></i> Create My Account
                        </button>
                    </div>
                </div>
            </form>

            <div class="rp-footer">
                Already have an account? <a href="#" onclick="showView('login');return false;">Sign In</a>
            </div>
        </div>

    </div><!-- /rp-inner -->
</div><!-- /right-panel -->

<script>
/* ── View switcher ── */
function showView(v) {
    document.getElementById('view-login').style.display    = v==='login'    ? '' : 'none';
    document.getElementById('view-register').style.display = v==='register' ? '' : 'none';
    document.getElementById('btnLogin').classList.toggle('active', v==='login');
    document.getElementById('btnReg').classList.toggle('active', v==='register');
}

/* ── Password toggle ── */
function toggleEye(id, btn) {
    const el = document.getElementById(id);
    el.type = el.type==='password' ? 'text' : 'password';
    btn.innerHTML = el.type==='password'
        ? '<i class="bi bi-eye"></i>'
        : '<i class="bi bi-eye-slash"></i>';
}

/* ── Role detector ── */
function detectRole(val) {
    const isEmail   = val.includes('@');
    const rAdmin    = document.getElementById('roleAdmin');
    const rStudent  = document.getElementById('roleStudent');
    const icon      = document.getElementById('loginIcon');
    const text      = document.getElementById('loginText');

    rAdmin.classList.remove('show');
    rStudent.classList.remove('show');

    if (val.length < 3) {
        icon.className = 'bi bi-box-arrow-in-right';
        text.textContent = 'Sign In to Portal';
        return;
    }
    if (isEmail) {
        rStudent.classList.add('show');
        icon.className = 'bi bi-person-fill';
        text.textContent = 'Sign In as Student';
    } else {
        rAdmin.classList.add('show');
        icon.className = 'bi bi-shield-fill';
        text.textContent = 'Sign In as Admin';
    }
}

/* ── Register password match ── */
document.getElementById('regForm').addEventListener('submit', function(e) {
    if (document.getElementById('rp1').value !== document.getElementById('rp2').value) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});

/* ── Trigger detect on page load if value already filled ── */
const idField = document.getElementById('identifier');
if (idField && idField.value) detectRole(idField.value);
</script>
</body>
</html>
