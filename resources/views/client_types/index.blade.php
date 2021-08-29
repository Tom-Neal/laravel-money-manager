@extends('layouts.app')
@section('page-title', 'Client Types')
@section('content')
<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>Client Types</h1>
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('client-types/create') }}">
                New Client Type
                <i class="fas fa-plus ms-1"></i>
            </a>
        </div>
    </div>
    <div class="card card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="table_center table_col_width_10">Client #</th>
                                <th class="table_center table_col_width_10">Icon</th>
                                <th class="table_center table_col_width_5">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientTypes as $clientType)
                                <tr>
                                    <td>{{ $clientType->name }}</td>
                                    <td class="table_center">
                                        {{ $clientType->clients_count }}
                                    </td>
                                    <td class="table_center">
                                        <i class="fas {{ $clientType->icon }}"></i>
                                    </td>
                                    <td class="table_center">
                                        <a class="btn btn-warning btn-sm" href="{{ url('client-types/edit', $clientType) }}">
                                            <i class="fas fa-wrench text-white" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
