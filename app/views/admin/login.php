<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Placement Cell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
<div class="auth-container">
    <div class="auth-card admin-auth">
        <div class="auth-header">
            <div class="auth-logo"><i class="bi bi-shield-lock-fill"></i></div>
            <h2>Admin Login</h2>
            <p>Training & Placement Cell</p>
        </div>
        <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="index.php?action=admin_login">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" id="adminPass" class="form-control" placeholder="Enter password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('adminPass', this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-auth w-100">
                <i class="bi bi-shield-check me-2"></i>Login as Admin
            </button>
        </form>
        <div class="auth-footer-links">
            <a href="index.php?page=home"><i class="bi bi-arrow-left"></i> Back to Website</a>
            <a href="login.php?type=student">Student Login</a>
        </div>
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
