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
    <!-- FAQ Header with Image -->
    <div class="row mb-5 justify-content-center align-items-center">
        <div class="col-auto text-center">
            <img src="{{ asset('assets/faq.png') }}" class="img-fluid" alt="FAQ illustration" />
        </div>
    </div>

    <!-- Frequently Asked Questions -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <h2 class="mb-4 text-center">Frequently Asked Questions</h2>
            <div class="accordion" id="faqAccordion">
                @for ($i = 1; $i <= 5; $i++)
                <div class="accordion-item mb-3">
                    <h2 class="accordion-header" id="heading{{ $i }}">
                        <button class="accordion-button {{ $i > 1 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}" aria-expanded="{{ $i == 1 ? 'true' : 'false' }}" aria-controls="collapse{{ $i }}">
                            <strong>FAQ Question {{ $i }} (alt for icon)</strong>
                        </button>
                    </h2>
                    <div id="collapse{{ $i }}" class="accordion-collapse collapse {{ $i == 1 ? 'show' : '' }}" aria-labelledby="heading{{ $i }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Voters Guidelines -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="mb-4">Voters Guidelines</h2>
            <ul class="list-group list-group-flush">
                @for ($j = 1; $j <= 7; $j++)
                <li class="list-group-item d-flex align-items-center">
                    <img src="your-guideline-icon.jpg" alt="Guideline icon {{ $j }}" class="me-3" style="width:32px; height:32px;" />
                    diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in.
                </li>
                @endfor
            </ul>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
