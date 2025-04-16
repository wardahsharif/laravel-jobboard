<nav class="navbar navbar-expand-lg navbar-dark dashboard-nav">
    <div class="container">
        <!-- Brand Name -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>

        <!-- Navbar Toggle for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('jobs.index') }}">Jobs</a>
                </li>

                <!-- Profile Dropdown -->
                @if(Auth::check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center fw-bold me-2"
     style="width: 32px; height: 32px; font-size: 14px;">
     {{ strtoupper(substr(auth()->user()->name ?? auth()->user()->username ?? 'U', 0, 1)) }}

</div>
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>

                            @if(auth()->user()->role === 'user')
                            <li><a class="dropdown-item" href="{{ route('application.index') }}">My Applications</a></li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
