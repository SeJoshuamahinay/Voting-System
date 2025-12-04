<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Vote2Voice - Voting Page</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <style>
        .hero-bg {
            background: linear-gradient(to bottom, #fff7d1, #ffeaa7);
            padding: 80px 0;
        }

        .candidate-card {
            border: 1px solid #cfcfcf;
            border-radius: 12px;
            padding: 20px;
            transition: 0.2s ease;
        }

        .candidate-card:hover {
            border-color: #6f42c1;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.06);
        }

        .candidate-img {
            width: 80px;
            height: 80px;
            background: #d7d7d7;
            border-radius: 50%;
        }

        .toggle-btn {
            border-radius: 20px;
            padding: 6px 25px;
        }

        .toggle-btn.active {
            background: #f8d54b;
            font-weight: 600;
        }
    </style>
</head>

<body>

<!-- NAV INCLUDE -->
@include('nav')

<!-- HERO SECTION -->
<section class="hero-bg">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Your Vote Matters!</h2>
                <p class="mb-4">Make your voice count. Select your candidate and submit your vote securely.</p>
                <a href="#" class="btn btn-primary px-4">Vote</a>
            </div>

            <div class="col-lg-6 text-center">
                <img src="" alt="Voting Illustration Placeholder" class="img-fluid">
            </div>

        </div>
    </div>
</section>

<!-- CATEGORY TOGGLE -->
<section class="py-4">
    <div class="container text-end">
        <button class="btn toggle-btn active">School</button>
        <button class="btn toggle-btn">Community</button>
    </div>
</section>

<!-- ELECTIONS IN PROGRESS -->
<section class="pb-5">
    <div class="container">
        <div class="p-4 border rounded-3 bg-white">

            <h4 class="fw-bold mb-2">Elections in Progress</h4>
            <p class="mb-4">
                Multiple elections are currently in progress. You may cast your vote for any active
                election. Make sure to check each one before the voting period ends.
            </p>

            <h6 class="fw-bold mb-3">School</h6>

            <div class="row g-4">

                <!-- Candidate Card 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="candidate-card d-flex gap-3 align-items-center justify-content-between">

                        <div class="d-flex gap-3 align-items-center">
                            <div class="candidate-img"></div>

                            <div>
                                <h6 class="fw-bold m-0">Candidate A</h6>
                                <small class="text-muted">President</small><br>
                                <small class="text-muted">Costa Party List</small>
                            </div>
                        </div>

                        <div>
                            <input type="radio" name="candidate1">
                            <label class="ms-1">Select</label>
                        </div>

                    </div>
                </div>

                <!-- Candidate Card 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="candidate-card d-flex gap-3 align-items-center justify-content-between">

                        <div class="d-flex gap-3 align-items-center">
                            <div class="candidate-img"></div>

                            <div>
                                <h6 class="fw-bold m-0">Candidate A</h6>
                                <small class="text-muted">President</small><br>
                                <small class="text-muted">Costa Party List</small>
                            </div>
                        </div>

                        <div>
                            <input type="radio" name="candidate2">
                            <label class="ms-1">Select</label>
                        </div>

                    </div>
                </div>

                <!-- Candidate Card 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="candidate-card d-flex gap-3 align-items-center justify-content-between">

                        <div class="d-flex gap-3 align-items-center">
                            <div class="candidate-img"></div>

                            <div>
                                <h6 class="fw-bold m-0">Candidate A</h6>
                                <small class="text-muted">President</small><br>
                                <small class="text-muted">Costa Party List</small>
                            </div>
                        </div>

                        <div>
                            <input type="radio" name="candidate3">
                            <label class="ms-1">Select</label>
                        </div>

                    </div>
                </div>

                <!-- Placeholder Slots -->
                <div class="col-md-6 col-lg-4">
                    <div class="candidate-card" style="height:150px;"></div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="candidate-card" style="height:150px;"></div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
