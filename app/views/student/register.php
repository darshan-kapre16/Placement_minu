<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | Placement Cell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="auth-page register-page">
<div class="auth-container" style="max-width:560px">
    <div class="auth-card student-auth">
        <div class="auth-header">
            <div class="auth-logo student-logo"><i class="bi bi-person-plus-fill"></i></div>
            <h2>Student Registration</h2>
            <p>Create your placement cell account</p>
        </div>
        <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="index.php?action=student_register">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Full Name *</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Your full name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email *</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="email@college.edu" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-phone-fill"></i></span>
                        <input type="tel" name="phone" class="form-control" placeholder="10-digit number">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Branch</label>
                    <select name="branch" class="form-select">
                        <option value="">-- Select Branch --</option>
                        <?php foreach (['CSE','IT','ECE','EEE','ME','CE','AIDS','AIML','DS'] as $b): ?>
                            <option value="<?= $b ?>"><?= $b ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Year</label>
                    <select name="year" class="form-select">
                        <option value="">Year</option>
                        <option>1st Year</option>
                        <option>2nd Year</option>
                        <option>3rd Year</option>
                        <option selected>Final Year</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">CGPA</label>
                    <input type="number" name="cgpa" class="form-control" step="0.01" min="0" max="10" placeholder="e.g. 7.5">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password *</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password" id="regPass" class="form-control" placeholder="Min 6 characters" required minlength="6">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass('regPass', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Password *</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" id="confirmPass" class="form-control" placeholder="Re-enter password" required>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-success btn-auth w-100" id="registerBtn">
                        <i class="bi bi-person-plus me-2"></i>Register Now
                    </button>
                </div>
            </div>
        </form>
        <div class="auth-footer-links">
            <a href="index.php?page=home"><i class="bi bi-arrow-left"></i> Back to Website</a>
            <a href="login.php?type=student">Already registered? Login</a>
        </div>
    </div>
</div>
<script>
function togglePass(id, btn) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
    btn.innerHTML = el.type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
}
document.getElementById('registerBtn').closest('form').addEventListener('submit', function(e) {
    const p1 = document.getElementById('regPass').value;
    const p2 = document.getElementById('confirmPass').value;
    if (p1 !== p2) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});
</script>
</body>
</html>
