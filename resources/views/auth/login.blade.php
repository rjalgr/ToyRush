<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ToyRush PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #FF6B35 0%, #FFD700 100%); min-height: 100vh; display: flex; align-items: center; }
        .auth-card { border: none; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,.2); }
        .brand { font-size: 2rem; font-weight: 800; color: #FF6B35; }
        .brand span { color: #FFD700; }
        .btn-primary { background: #FF6B35; border-color: #FF6B35; }
        .btn-primary:hover { background: #e55a27; }
        .input-group .btn-outline-secondary { border-color: #dee2e6; color: #6c757d; }
        .input-group .btn-outline-secondary:hover { background: #f8f9fa; color: #333; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="auth-card card p-5">
                <div class="text-center mb-4">
                    <div class="brand">Toy<span>Rush</span></div>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', 'eyeIcon')">
                                <i id="eyeIcon" class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Sign In</button>
                </form>
                <div class="text-center mt-4">
                    <p class="text-muted mb-1">No account? <a href="{{ route('register') }}" class="fw-semibold" style="color:#FF6B35">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
</body>
</html>