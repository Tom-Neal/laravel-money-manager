<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}">
                    <h2 class="mt-2">{{ config('app.name') }}</h2>
                </a>
                <div class="collapse navbar-collapse" id="navbar">
                    <h3 id="title" class="me-auto text-white mt-2"></h3>
                    <ul class="d-flex navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ url('users/profile', auth()->user()->id) }}">
                                        <i class="fas fa-wrench me-1"></i>
                                        Update Profile
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ url('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" >
                                            <i class="fas fa-power-off me-1"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
