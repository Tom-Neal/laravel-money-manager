<div id="sidebar-wrapper" class="border-right">
    <a class="sidebar-heading d-flex justify-content-center text-white" href="{{ route('home') }}">
        {{ config('app.name') }}
    </a>
    <div class="list-group list-group-flush">
        <a href="{{ route('home') }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-home me-1"></i>
            Home
        </a>
        <a href="{{ url('users/profile', auth()->user()) }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-wrench me-1"></i>
            Update Profile
        </a>
        <a href="{{ url('settings/edit', App\Models\Setting::PREFERENCES) }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-cogs me-1"></i>
            Settings
        </a>
        <form class="list-group-item p-0" method="POST" action="{{ url('logout') }}">
            @csrf
            <button class="bg-primary border-0 w-100 pt-3 pb-3" style="color: #8391a2;">
                <i class="fas fa-power-off me-1"></i>
                Logout
            </button>
        </form>
    </div>
</div>
