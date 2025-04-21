<nav class="navbar navbar-expand-lg navbar-light"  style="background: linear-gradient(135deg,rgb(144, 183, 245),rgb(229, 157, 232));">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ route('home') }}">
            Job Seek
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNavbar" aria-controls="guestNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="guestNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#hero">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#featured-jobs">Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#how-it-works">How It Works</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#about">About</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item me-2">
                    <a  class="text-white" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="text-white" href="{{ route('register') }}">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
