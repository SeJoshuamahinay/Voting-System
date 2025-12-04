<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vote2Voice - Voting Page</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height:100vh;">
        <!-- Logo Row -->
        <div class="mb-4 w-100 d-flex align-items-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Vote2Voice Logo" style="height:48px;" />
        </div>
        <!-- Login Card -->
        <div class="card shadow"
            style="max-width:400px; width:100%; border-radius:2rem; border-width:4px; border-style:solid; border-image:linear-gradient(90deg, #f00, #ff0, #0f0, #00f) 1;">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-4">Log In</h2>
                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">E-mail</label>
                        <input type="email" class="form-control border-0 border-bottom" id="email"
                            placeholder="Enter your email">
                    </div>
                    <div class="mb-1 position-relative">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control border-0 border-bottom" id="password"
                                placeholder="Enter your password">
                            <span class="input-group-text bg-white border-0" style="cursor:pointer;"
                                id="togglePassword">
                                <i class="bi bi-eye" style="font-size:1.5rem; color:black;"
                                    aria-label="Show password"></i>
                            </span>

                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <a href="#" class="text-decoration-none small">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn w-100 mb-3"
                        style="background:#ffd600; color:#222; border-radius:2rem; font-weight:bold;">Log In</button>
                    <div class="d-flex align-items-center mb-3">
                        <hr class="flex-grow-1">
                        <span class="mx-2 text-muted small">Or</span>
                        <hr class="flex-grow-1">
                    </div>
                    <a href="#" class="btn w-100"
                        style="background:#ccc; color:#222; border-radius:2rem; font-weight:bold;">Sign Up</a>
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