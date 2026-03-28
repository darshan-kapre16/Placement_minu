<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | Placement Cell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
<div class="auth-container">
    <div class="auth-card student-auth">
        <div class="auth-header">
            <div class="auth-logo student-logo"><i class="bi bi-person-badge-fill"></i></div>
            <h2>Student Login</h2>
            <p>Training & Placement Cell</p>
        </div>
        <?php if (!empty($_SESSION['register_success'])): ?>
            <div class="alert alert-success d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($_SESSION['register_success']) ?>
            </div>
            <?php unset($_SESSION['register_success']); ?>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="index.php?action=student_login">
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="your@email.com" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" id="stuPass" class="form-control" placeholder="Enter password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('stuPass', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-auth w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>
        </form>
        <div class="auth-footer-links">
            <a href="index.php?page=home"><i class="bi bi-arrow-left"></i> Back to Website</a>
            <a href="index.php?page=register">New Student? Register</a>
        </div>
        <div class="auth-divider">or</div>
        <a href="login.php?type=admin" class="btn btn-outline-secondary w-100 btn-sm">
            <i class="bi bi-shield-lock me-2"></i>Admin Login
        </a>
    </div>
</div>
<script>
function togglePass(id, btn) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
    btn.innerHTML = el.type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
}
</script>
</body>
</html>
