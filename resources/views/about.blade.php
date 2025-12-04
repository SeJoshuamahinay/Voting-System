<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Vote2Voice - Voting Page</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>

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
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lectus tortor,
            dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultricies diam.
        </p>
    </div>
</section>


{{-- MISSION SECTION --}}
<section class="py-5">
    <div class="container">
        <h5 class="fw-bold mb-3">Our Mission:</h5>

        <div class="mission-box">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse lectus tortor,
                dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultricies diam.
                Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec
                nonummy molestie, enim est eleifend mi.
            </p>
        </div>
    </div>
</section>


{{-- FEATURES SECTION --}}
<section class="py-5 text-center">
    <div class="container">
        <h4 class="fw-bold mb-2">Our Features</h4>

        <p class="mb-5" style="max-width: 700px; margin: auto;">
            Cras elementum ultricies diam. Maecenas ligula massa, varius a, semper congue,
            euismod non, mi. Proin porttitor, orci nec nonummy molestie.
        </p>

        <div class="row g-5">
            <div class="col-md-4">
                <div class="feature-icon">
                    <img src="/assets/icons/graph.png" width="80">
                </div>
                <h6>Real Time Results</h6>
                <p class="small">
                    Dolor. Cras elementum ultricies diam. Maecenas ligula massa.
                </p>
            </div>

            <div class="col-md-4">
                <div class="feature-icon">
                    <img src="/assets/icons/vote.png" width="80">
                </div>
                <h6>Vote Online</h6>
                <p class="small">
                    Elementum ultricies diam. Maecenas ligula massa.
                </p>
            </div>

            <div class="col-md-4">
                <div class="feature-icon">
                    <img src="/assets/icons/security.png" width="80">
                </div>
                <h6>Secured Platform</h6>
                <p class="small">
                    Ligula massa, varius a, semper congue, euismod.
                </p>
            </div>
        </div>
    </div>
</section>


{{-- PROCESS STEPS --}}
<section class="py-5">
    <div class="container text-center">
        <h4 class="fw-bold">How Vote2Voice Works</h4>
        <p class="small text-muted mb-5">A Simple Way to Secure Your Vote</p>

        <div class="row g-4">

            {{-- STEP 1 --}}
            <div class="col-md-4">
                <div class="step-card">
                    <img src="/assets/steps/account.png">
                    <div class="p-3 text-start">
                        <h6>Create Your Account</h6>
                        <p class="small">
                            Join our secure platform in seconds. Verify your credentials and ensure only you can cast your vote.
                        </p>
                        <a href="#" class="small">See More →</a>
                    </div>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div class="col-md-4">
                <div class="step-card">
                    <img src="/assets/steps/vote.png">
                    <div class="p-3 text-start">
                        <h6>Cast Your Vote</h6>
                        <p class="small">
                            Make your choice with one click. Your vote is encrypted, traceable, and tamper-proof.
                        </p>
                        <a href="#" class="small">See More →</a>
                    </div>
                </div>
            </div>

            {{-- STEP 3 --}}
            <div class="col-md-4">
                <div class="step-card">
                    <img src="/assets/steps/results.png">
                    <div class="p-3 text-start">
                        <h6>View Results</h6>
                        <p class="small">
                            Results are displayed instantly with transparency—no waiting, no doubts.
                        </p>
                        <a href="#" class="small">See More →</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
