<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ToyRush PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #FF6B35 0%, #FFD700 100%); min-height: 100vh; display: flex; align-items: center; padding: 30px 0; }
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
        <div class="col-md-6">
            <div class="auth-card card p-5">
                <div class="text-center mb-4">
                    <div class="brand">Toy<span>Rush</span></div>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password', 'eyeIcon1')">
                                    <i id="eyeIcon1" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                                    <i id="eyeIcon2" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone (Optional)</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address (Optional)</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">Create Account</button>
                </form>
                <div class="text-center mt-3">
                    <p class="text-muted">Already have an account? <a href="{{ route('login') }}" class="fw-semibold" style="color:#FF6B35">Sign In</a></p>
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