<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ route('home') }}">
            Job Seek
        </a>
        
        <!-- Responsive toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNavbar" aria-controls="guestNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="guestNavbar">
            <ul class="navbar-nav">
                <li class="nav-item me-2">
                    <a class="btn btn-secondary btn-light text-dark mb-2" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary btn-outline-light" href="{{ route('register') }}">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
