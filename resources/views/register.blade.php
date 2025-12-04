<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vote2Voice - Register</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height:100vh;">
        <!-- Logo Row -->
        <div class="mb-4 w-100 d-flex align-items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Vote2Voice Logo" style="height:48px;" />
        </div>
        <!-- Register Card -->
        <div class="card shadow"
            style="max-width:400px; width:100%; border-radius:2rem; border-width:4px; border-style:solid; border-image:linear-gradient(90deg, #f00, #ff0, #0f0, #00f) 1;">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-4">Sign Up</h2>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Full Name</label>
                        <input type="text" class="form-control border-0 border-bottom" id="name" name="name"
                            placeholder="Enter your full name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">E-mail</label>
                        <input type="email" class="form-control border-0 border-bottom" id="email" name="email"
                            placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-0 border-bottom" id="password" name="password"
                                placeholder="Enter your password" required>
                            <span class="input-group-text bg-white border-0" style="cursor:pointer;"
                                id="togglePassword">
                                <i class="bi bi-eye" style="font-size:1.5rem; color:black;"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-4 position-relative">
                        <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-0 border-bottom" id="password_confirmation" name="password_confirmation"
                                placeholder="Confirm your password" required>
                            <span class="input-group-text bg-white border-0" style="cursor:pointer;"
                                id="togglePasswordConfirm">
                                <i class="bi bi-eye" style="font-size:1.5rem; color:black;"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn w-100 mb-3"
                        style="background:#ffd600; color:#222; border-radius:2rem; font-weight:bold;">Sign Up</button>
                    <div class="d-flex align-items-center mb-3">
                        <hr class="flex-grow-1">
                        <span class="mx-2 text-muted small">Or</span>
                        <hr class="flex-grow-1">
                    </div>
                    <a href="{{ route('login') }}" class="btn w-100"
                        style="background:#ccc; color:#222; border-radius:2rem; font-weight:bold;">Log In</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggle = document.getElementById('togglePassword');
            const icon = toggle.querySelector('i');
            toggle.addEventListener('click', function () {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });

            const passwordConfirmInput = document.getElementById('password_confirmation');
            const toggleConfirm = document.getElementById('togglePasswordConfirm');
            const iconConfirm = toggleConfirm.querySelector('i');
            toggleConfirm.addEventListener('click', function () {
                const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
                passwordConfirmInput.type = type;
                iconConfirm.classList.toggle('bi-eye');
                iconConfirm.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>

</html>
