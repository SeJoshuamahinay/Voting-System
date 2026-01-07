<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vote2Voice</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Icons (Optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Additional Styling */
        .hero-section {
            padding: 80px 0;
            background-image: url('{{ asset('assets/wave.svg') }}');
            background-size: cover;
            
        }

        .feature-icon {
            font-size: 40px;
            color: #ff4c4c;
        }

        .faq-item button {
            width: 100%;
            text-align: left;
        }

        .footer-bg {
            background: #f8d54b;
            padding: 30px 0;
        }
    </style>
</head>

<body>

   @include('nav')
    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6">
                    <h2 class="fw-bold mb-3" style="color:red">DIGITAL VOTING SYSTEM FOR<br> COMMUNITY-BASED ELECTIONS</h2>
                    <p class="mb-4"  style="color:blue">
                        A secure and transparent digital voting system designed for small community-based elections.
                    </p>
                    <a href="#" class="btn px-4 py-2 rounded-pill border-0"
                        style="background: linear-gradient(90deg, #F9AB26 0%, #FFCE81 100%); color: #fff; font-weight: bold; box-shadow: 0 2px 8px ">
                        Get Started
                    </a>
                </div>

                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/hero_illustration.png') }}" class="img-fluid"
                        alt="Hero Illustration Placeholder">
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="py-5">
        <div class="container text-center">
            <div class="row g-4">

                <div class="col-md-4">
                    <i class="bi bi-shield-lock feature-icon"></i>
                    <h5 class="fw-bold mt-2">Secure Voting</h5>
                </div>

                <div class="col-md-4">
                    <i class="bi bi-graph-up feature-icon"></i>
                    <h5 class="fw-bold mt-2">Real-Time Results</h5>
                </div>

                <div class="col-md-4">
                    <i class="bi bi-file-earmark-text feature-icon"></i>
                    <h5 class="fw-bold mt-2">Transparent Reports</h5>
                </div>

            </div>
        </div>
    </section>

    <!-- DASHBOARD PREVIEW SECTION -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/dashboard_preview.png') }}" class="img-fluid rounded"
                        alt="Dashboard Preview Placeholder">
                </div>

                <div class="col-lg-6">
                    <h3 class="fw-bold">Vote securely and make your voice count.</h3>
                    <p class="mb-3">
                        Experience a faster, safer, and more transparent way to vote. Fairness with encrypted ballots,
                        one-vote-per-user access, and real-time result tracking all in one platform.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- HOW IT WORKS SECTION -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h3 class="fw-bold mb-4">How Vote2Voice Works</h3>
            <div class="row g-10">
                <div class="row g-20">
                    <div class="col-md-4 border rounded border-black">
                        <!-- top container row with detail and logo -->
                        <div>
                            <i class="bi bi-person-plus-fill fs-1 mb-3 d-block"></i>
                            <h5 class="fw-bold">Create Your Account</h5>
                            <p>Your verified account ensures one person, one vote.</p>
                            <a href="#" class="text-white text-decoration-none fw-bold">See More →</a>
                        </div>
                          <!-- bottom container row with image bg-->
                         <div>
                            <img src="{{ asset('assets/create.png') }}" alt="Create Account Illustration" class="img-fluid ">
                        </div>
                    </div>
                    <div class="col-md-4 border rounded border-black">
                        <!-- top container row with detail and logo -->
                        <div>
                            <i class="bi bi-check2-square fs-1 mb-3 d-block"></i>
                            <h5 class="fw-bold">Cast Your Vote</h5>
                            <p>Your vote is encrypted, traceable, and tamper-proof.</p>
                            <a href="#" class="text-white text-decoration-none fw-bold">See More →</a>
                        </div>
                        <div>
                            <img src="{{ asset('assets/cast.png') }}" alt="Cast Vote Illustration" class="img-fluid ">
                        </div>
                    </div>
                    <div class="col-md-4 border rounded border-black">
                        <!-- top container row with detail and logo -->
                        <div>
                            <i class="bi bi-bar-chart-fill fs-1 mb-3 d-block"></i>
                            <h5 class="fw-bold">View Results</h5>
                            <p>Results are displayed instantly with real-time summaries.</p>
                            <a href="#" class="text-white text-decoration-none fw-bold">See More →</a>
                        </div>
                        <div>
                            <img src="{{ asset('assets/results.png') }}" alt="View Results Illustration"
                                class="img-fluid ">
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- FOOTER SECTION -->
    <footer class="footer-bg pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a class="navbar-brand fw-bold" href="#">
                        <img src="{{ asset('assets/logo.png') }}" alt="Vote2Voice Logo" width="150" class="me-2">
                    </a>
                    <ul class="list-unstyled mt-3">
                        <li><a href="#" class="text-dark">About Vote2Voice</a></li>
                        <li><a href="#" class="text-dark">Voting Guidelines</a></li>
                        <li><a href="#" class="text-dark">How to Use</a></li>
                        <li><a href="#" class="text-dark">FAQs</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h6 class="fw-bold">Based in</h6>
                    <p>Bacoor, Cavite, Philippines</p>

                    <h6 class="fw-bold mt-3">Contact Us</h6>
                    <p>Email: vote2voice@gmail.com</p>

                    <div>
                        <i class="bi bi-facebook fs-4 me-2"></i>
                        <i class="bi bi-twitter fs-4 me-2"></i>
                        <i class="bi bi-instagram fs-4"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <h6 class="fw-bold">Message Us</h6>
                    <form class="mt-3">
                        <input type="text" class="form-control mb-2" placeholder="Full Name" />
                        <input type="email" class="form-control mb-2" placeholder="Email" />
                        <textarea class="form-control mb-2" rows="3" placeholder="Message"></textarea>

                        <button class="btn btn-dark w-100">Send Message</button>
                    </form>
                </div>

            </div>

            <div class="text-center mt-4">
                © 2025 Vote2Voice. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>