<div id="sidebar-wrapper" class="border-right">
    <a class="sidebar-heading d-flex justify-content-center text-white" href="{{ route('home') }}">
        {{ config('app.name') }}
    </a>
    <div class="list-group list-group-flush">
        <a href="{{ route('home') }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-home me-1"></i>
            Home
        </a>
        @foreach($clientTypes as $clientType)
            <a href="{{ url('client-types/show', $clientType) }}" class="list-group-item pt-3 pb-3">
                <i class="fas {{ $clientType->icon }} me-1"></i>
                {{ $clientType->name }} Clients
            </a>
        @endforeach
        <a href="{{ url('client-types') }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-users me-1"></i>
            Client Types
        </a>
        <a href="{{ url('invoices') }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-money-check me-1"></i>
            Invoices
        </a>
        <a href="{{ url('expenses') }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-money-bill me-1"></i>
            Expenses
        </a>
        <a href="{{ url('statements') }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-cash-register me-1"></i>
            Statements
        </a>
        <a href="{{ url('media') }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-file-download me-1"></i>
            File Storage
        </a>
        <a href="{{ url('comments') }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-comment me-1"></i>
            Comments
        </a>
        <a href="{{ url('settings/edit', App\Models\Setting::PREFERENCES) }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-cogs me-1"></i>
            Settings
        </a>
        <a href="{{ url('users/profile') }}" class="list-group-item pt-3 pb-3">
            <i class="fas fa-wrench me-1"></i>
            Update Profile
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
