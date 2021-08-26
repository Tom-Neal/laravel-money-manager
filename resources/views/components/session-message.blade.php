@if(session('message'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert @if(session('type')) alert-{{ session('type') }} @else alert-info @endif d-flex justify-content-between" role="alert">
                <span class="fw-bold">{!!session('message')!!}</span>
                <a class="close" data-bs-dismiss="alert" aria-label="Close">×</a>
            </div>
        </div>
    </div>
@endif
