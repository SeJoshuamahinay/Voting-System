<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vote2Voice - Guidelines & FAQs</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .faq-answer {
            transition: max-height 0.3s ease, opacity 0.3s ease;
        }
    </style>
</head>

<body>

{{-- NAVIGATION --}}
@include('nav')

<div class="container py-5">
    {{-- Top Image --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            {{-- Main Guidelines Icon (PNG) --}}
            <img src="{{ asset('assets/faq.png') }}" alt="Vote2Voice guidelines icon" class="img-fluid mb-3" style="max-height: 120px;">
        </div>
    </div>

    {{-- Voter Guidelines --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <h2 class="mb-4 text-center">Voter Guidelines</h2>
            <ul class="list-group list-group-flush">
                @php
                    $guidelines = [
                        "Ensure your account is registered and verified before the election to vote securely.",
                        "Each voter can only vote once per election. Multiple votes are allowed per position.",
                        "Follow the official election period. Votes outside the designated start and end times will not be counted.",
                        "Check candidate information before voting to make an informed decision.",
                        "Fraudulent activity or vote manipulation is prohibited. The system monitors suspicious behavior automatically.",
                        "After voting, you will receive a confirmation for transparency and verification.",
                        "Detailed reports summarizing total votes, turnout, and election outcomes are available for review after the election concludes."
                    ];
                @endphp

                @foreach($guidelines as $index => $guideline)
                    <li class="list-group-item d-flex align-items-center">
                        <img src="{{ asset('assets/guideline.png') }}" alt="Guideline icon {{ $index + 1 }}" class="me-3" style="width:32px; height:32px;" />
                        {{ $guideline }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Frequently Asked Questions --}}
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Frequently Asked Questions</h2>
        </div>

        {{-- Left Column --}}
        <div class="col-md-6 mb-4 mb-md-0">
            @php
                $faqsLeft = [
                    ["question" => "What are the community rules?", "answer" => "Our rules promote respect, safety, and constructive engagement across all interactions."],
                    ["question" => "How is user safety maintained?", "answer" => "We use moderation tools, reporting systems, and proactive monitoring to ensure safety."],
                    ["question" => "Are there content restrictions?", "answer" => "Yes, content must comply with our terms—no hate speech, harassment, or illegal material."],
                    ["question" => "Can guidelines change over time?", "answer" => "Absolutely. We update guidelines to reflect evolving standards and community needs."]
                ];
            @endphp

            @foreach($faqsLeft as $faq)
                <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                    <div class="faq-question d-flex justify-content-between align-items-center" style="cursor:pointer;">
                        <span>{{ $faq['question'] }}</span>
                        <span class="arrow">▼</span>
                    </div>
                    <div class="faq-answer mt-2 text-muted d-none">
                        {{ $faq['answer'] }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Right Column --}}
        <div class="col-md-6">
            @php
                $faqsRight = [
                    ["question" => "Who enforces the guidelines?", "answer" => "Our moderation team and automated systems work together to enforce rules fairly."],
                    ["question" => "What happens if rules are broken?", "answer" => "Violations may result in warnings, suspensions, or permanent bans depending on severity."],
                    ["question" => "Can I report violations anonymously?", "answer" => "Yes, anonymous reporting is available to protect your identity and encourage safe reporting."],
                    ["question" => "How often are guidelines reviewed?", "answer" => "We review them quarterly and after major platform updates or community feedback."]
                ];
            @endphp

            @foreach($faqsRight as $faq)
                <div class="faq-item mb-3 p-3 bg-white shadow-sm rounded">
                    <div class="faq-question d-flex justify-content-between align-items-center" style="cursor:pointer;">
                        <span>{{ $faq['question'] }}</span>
                        <span class="arrow">▼</span>
                    </div>
                    <div class="faq-answer mt-2 text-muted d-none">
                        {{ $faq['answer'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const arrow = item.querySelector('.arrow');

        question.addEventListener('click', () => {
            answer.classList.toggle('d-none');
            arrow.textContent = answer.classList.contains('d-none') ? '▼' : '▲';
        });
    });
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
