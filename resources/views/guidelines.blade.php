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
    @extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Guidelines</h1>

    <div class="row">
        {{-- Left Column --}}
        <div class="col-md-6">
            <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                <div class="faq-question d-flex justify-content-between align-items-center">
                    <span>What are the community rules?</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="faq-answer mt-2 text-muted d-none">
                    Our rules promote respect, safety, and constructive engagement across all interactions.
                </div>
            </div>

            <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                <div class="faq-question d-flex justify-content-between align-items-center">
                    <span>How is user safety maintained?</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="faq-answer mt-2 text-muted d-none">
                    We use moderation tools, reporting systems, and proactive monitoring to ensure safety.
                </div>
            </div>

            <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                <div class="faq-question d-flex justify-content-between align-items-center">
                    <span>Are there content restrictions?</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="faq-answer mt-2 text-muted d-none">
                    Yes, content must comply with our terms—no hate speech, harassment, or illegal material.
                </div>
            </div>

            <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                <div class="faq-question d-flex justify-content-between align-items-center">
                    <span>Can guidelines change over time?</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="faq-answer mt-2 text-muted d-none">
                    Absolutely. We update guidelines to reflect evolving standards and community needs.
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="col-md-6">
            <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                <div class="faq-question d-flex justify-content-between align-items-center">
                    <span>Who enforces the guidelines?</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="faq-answer mt-2 text-muted d-none">
                    Our moderation team and automated systems work together to enforce rules fairly.
                </div>
            </div>

            <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                <div class="faq-question d-flex justify-content-between align-items-center">
                    <span>What happens if rules are broken?</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="faq-answer mt-2 text-muted d-none">
                    Violations may result in warnings, suspensions, or permanent bans depending on severity.
                </div>
            </div>

            <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                <div class="faq-question d-flex justify-content-between align-items-center">
                    <span>Can I report violations anonymously?</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="faq-answer mt-2 text-muted d-none">
                    Yes, anonymous reporting is available to protect your identity and encourage safe reporting.
                </div>
            </div>

            <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                <div class="faq-question d-flex justify-content-between align-items-center">
                    <span>How often are guidelines reviewed?</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="faq-answer mt-2 text-muted d-none">
                    We review them quarterly and after major platform updates or community feedback.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
            const answer = item.querySelector('.faq-answer');
            const arrow = item.querySelector('.arrow');
            answer.classList.toggle('d-none');
            arrow.style.transform = item.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    });
</script>
@endpush


    <!-- Voters Guidelines -->
    <div class="row justify-content-center">
    <div class="col-lg-8">
        <h2 class="mb-4">Voters Guidelines</h2>
        <ul class="list-group list-group-flush">
            @php
                $guidelines = [
                    "Check your voter registration before the election.",
                    "Bring a valid ID to the polling station.",
                    "Vote only once and follow the official procedures.",
                    "Respect other voters and maintain order.",
                    "Follow all instructions given by election staff.",
                    "Ensure your ballot is filled out clearly and correctly.",
                    "Report any irregularities to the proper authorities."
                ];
            @endphp

            @foreach ($guidelines as $index => $guideline)
                <li class="list-group-item d-flex align-items-center">
                    <img src="/assets/guideline.png" alt="Guideline icon {{ $index + 1 }}" class="me-3" style="width:32px; height:32px;" />
                    {{ $guideline }}
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
