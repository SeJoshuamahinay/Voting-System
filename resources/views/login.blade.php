<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vote2Voice - Voting Page</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height:100vh;">
        <!-- Logo Row -->
            <div class="mb-4 w-100 d-flex align-items-center">
                <a href="{{ route('welcome') }}">
                <img src="{{ asset('assets/logo.png') }}" alt="Vote2Voice Logo" style="height:48px;" />
                </a>
            </div>
        <!-- Login Card -->
        <div class="card shadow"
            style="max-width:400px; width:100%; border-radius:2rem; border-width:4px; border-style:solid; border-image:linear-gradient(90deg, #f00, #ff0, #0f0, #00f) 1;">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-4">Log In</h2>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">E-mail</label>
                        <input type="email" class="form-control border-0 border-bottom" id="email" name="email"
                            placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-1 position-relative">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="d-flex align-items-center border-bottom">
                            <input type="password" class="form-control border-0 flex-grow-1" id="password" name="password"
                                placeholder="Enter your password" required style="box-shadow: none;">
                            <button type="button" class="btn btn-link p-0 border-0" id="togglePassword" style="text-decoration: none;">
                                <i class="bi bi-eye" style="font-size:1.25rem; color:#666;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small" for="remember">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="text-decoration-none small">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn w-100 mb-3"
                        style="background:#ffd600; color:#222; border-radius:2rem; font-weight:bold;">Log In</button>
                    <div class="d-flex align-items-center mb-3">
                        <hr class="flex-grow-1">
                        <span class="mx-2 text-muted small">Or</span>
                        <hr class="flex-grow-1">
                    </div>
                    <a href="{{ route('register') }}" class="text-decoration-underline justify-content-center d-flex">Create an account?</a>
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
        });
    </script>
    </body>

</html>