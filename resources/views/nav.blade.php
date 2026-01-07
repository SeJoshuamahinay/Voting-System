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
                <li class="nav-item"><a class="nav-link" href="{{ route('voting.index')  }}">Vote</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('guidelines') }}">Guidelines & FAQs</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('results') }}">Results</a></li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            @if(auth()->user()->hasRole('administrator') || auth()->user()->hasRole('moderator') || auth()->user()->hasPermission('manage-users') || auth()->user()->hasPermission('manage-roles') || auth()->user()->hasPermission('manage-permissions'))
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn fw-bold"
                           href="{{ route('login') }}"
                           style="border-width:2px; border-style:solid; border-color:#007bff #ffc107 #dc3545;">
                            Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>