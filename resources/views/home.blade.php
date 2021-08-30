@extends('layouts.app')
@section('page-title', 'Home')
@section('content')
<div id="page" class="container">
    @if($clientTypes->isNotEmpty())
        <div class="row mb-3">
            @foreach($clientTypes as $clientType)
                <div class="col-md-6">
                    <a class="btn btn-primary w-100 py-3 mb-3" href="{{ url('client-types/show', $clientType) }}">
                        {{ $clientType->name }} Clients
                        <i class="fas {{ $clientType->icon }} ms-1"></i>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
