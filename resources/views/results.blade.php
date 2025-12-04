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
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h2 class="fw-bold">Hello! Welcome to the Election Results</h2>
            <p>Your vote has been counted — view the results below.</p>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Ongoing Elections</h5>
                    <p class="card-text text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                    <h4 class="fw-bold mt-3">President Student Election</h4>
                    <a href="#" class="btn btn-outline-primary mt-3">Vote now</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <img src="your-results-illustration.jpg" class="img-fluid" alt="Results illustration" />
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Real-Time Vote Tally</h5>
                        <span class="badge bg-success">Voting in Progress</span>
                    </div>
                    <!-- Chart Placeholder -->
                    <div class="my-3" style="height:250px; background:#eee; display:flex; align-items:center; justify-content:center;">
                        <span class="text-muted">[Chart goes here]</span>
                    </div>
                    <!-- Legend Example -->
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-danger">Mr. Krabs</span>
                        <span class="badge bg-warning text-dark">Spongebob</span>
                        <span class="badge bg-primary">Plankton</span>
                        <span class="badge bg-success">Sandy</span>
                        <span class="badge bg-secondary">Squidward</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm" style="height:250px;">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <span class="text-muted">[Alternative content or image here, alt="Result component"]</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm" style="height:300px;">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <span class="text-muted">[Alternative content or image here, alt="Result component"]</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm" style="height:300px;">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <span class="text-muted">[Alternative content or image here, alt="Result component"]</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
