<div class="d-flex" id="wrapper">
    @include('layouts.sidebar')
    <div id="page-content-wrapper" class="d-flex flex-column mb-3">
        <nav class="navbar navbar-expand-lg">
            <button id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
        @yield('content')
        @include('layouts.footer')
    </div>
</div>
