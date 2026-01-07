<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vote2Voice - Voting Page</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    {{-- NAVIGATION --}}
    @include('nav')

    <style>
        .about-hero {
            background: linear-gradient(180deg, #FDF4C9 0%, #FFEBA8 40%, #FFF7DA 100%);
            padding: 80px 0 120px 0;
        }

        .about-hero h2 {
            font-size: 32px;
            font-weight: 700;
        }

        .mission-box {
            background: #F4F4F4;
            padding: 40px;
            border-radius: 4px;
        }

        .feature-icon {
            width: 140px;
            height: 140px;
            border-radius: 100%;
            padding: 25px;
            background: #FFE7A1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
        }

        .step-card {
            width: 100%;
            border: 2px solid #000;
            border-radius: 12px;
            overflow: hidden;
        }

        .step-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
    </style>

    {{-- HERO SECTION --}}
    <section class="about-hero text-center">
        <div class="container">
            <h2>About Vote2Voice</h2>

            <p class="mt-3" style="max-width: 750px; margin: auto;">
                Vote2Voice is a secure, transparent, and flexible digital voting system designed specifically for small communities such as CvSU-Bacoor. The system aims to modernize the voting process by replacing traditional manual methods with a reliable digital platform that prioritizes security, efficiency, and user experience.

           </p>
        </div>
    </section>


    {{-- MISSION SECTION --}}
    <section class="py-5">
        <div class="container">
            <h5 class="fw-bold mb-3">Our Mission:</h5>

            <div class="mission-box">
                <p>
                    The mission of Vote2Voice is to provide a secure, transparent, and reliable digital voting platform that empowers small communities to conduct fair and efficient elections. The system aims to uphold the integrity of the voting process by enforcing one-person-one-vote principles, protecting voter privacy through encryption and anonymity, and delivering accurate results through real-time vote counting and automated reporting.
                </p>
            </div>
        </div>
    </section>


    {{-- FEATURES SECTION --}}
    <section class="py-5 text-center">
        <div class="container">
            <h4 class="fw-bold mb-2">Our Features</h4>

            <p class="mb-5" style="max-width: 700px; margin: auto;">
                Ensures that only authorized users can participate in the voting process, providing a secure login mechanism for voters.
            </p>

            <div class="row g-5">
                <div class="col-md-4">
                    <div class="feature-icon">
                        <img src="{{ asset('assets/realtime.png') }}" alt="Vote2Voice Logo" width="80" class="me-2">
                    </div>
                    <h6>Real Time Results</h6>
                    <p class="small">
                        Allows for the immediate tallying of votes once the voting period ends.
                    </p>
                </div>

                <div class="col-md-4">
                    <div class="feature-icon">
                        <img src="/assets/vote.png" width="80">
                    </div>
                    <h6>Vote Online</h6>
                    <p class="small">
                         Provides flexibility in the types of elections that can be held within the platform.
                    </p>
                </div>

                <div class="col-md-4">
                    <div class="feature-icon">
                        <img src="/assets/security.png" width="80">
                    </div>
                    <h6>Secured Platform</h6>
                    <p class="small">
                        Ensures that only authorized users can participate in the voting process, providing a secure login mechanism for voters.
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- PROCESS STEPS --}}
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


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>