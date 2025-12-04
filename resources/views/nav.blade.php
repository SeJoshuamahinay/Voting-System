<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('welcome') }}">
            <img src="{{ asset('assets/logo.png') }}" alt="Vote2Voice Logo" width="150" class="me-2">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto gap-3 fw-semibold">
                <li class="nav-item"><a class="nav-link" href="{{ route('welcome') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('voting') }}">Vote</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('guidelines') }}">Guidelines & FAQs</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('results') }}">Results</a></li>
                <li class="nav-item">
                    <a class="btn fw-bold"
                       href="{{ route('login') }}"
                       style="border-width:2px; border-style:solid; border-color:#007bff #ffc107 #dc3545;">
                        Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>