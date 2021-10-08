@extends('layouts.app')
@section('page-title', 'Edit Expense')
@section('content')
<div id="page" class="container">
    <x-session-message></x-session-message>
    <div class="row mb-3 align-items-end">
        <div class="col">
            <h1>Edit Expense</h1>
        </div>
        <div class="col-md-auto d-grid gap-2 d-md-flex justify-content-md-end mt-2">
            <a class="btn btn-primary" href="{{ url('expenses') }}">
                <i class="fas fa-arrow-left me-1"></i>
                Back to Expenses
            </a>
        </div>
    </div>
    <div class="card card-body mb-3">
        <form class="row" method="POST" action="{{ url('expenses', $expense) }}">
            @csrf
            @method('PATCH')
            <x-error></x-error>
            <div class="mb-3 col-md-12">
                <label class="control-label" for="description">Description</label>
                <textarea class="form-control" name="description">{{ old('description', $expense->description) }}</textarea>
            </div>
            <div class="mb-3 col-md-4">
                <label class="control-label" for="price">Price</label>
                <input class="form-control" name="price" type="number" value="{{ old('price', $expense->price) }}" />
            </div>
            <div class="mb-3 col-md-4">
                <label class="control-label" for="price_with_vat">Price (with VAT)</label>
                <input class="form-control" name="price_with_vat" type="number" value="{{ old('price_with_vat', $expense->price_with_vat) }}" />
            </div>
            <div class="mb-3 col-md-4">
                <label class="control-label" for="vat_included">VAT included?</label>
                <input class="form-check" name="vat_included" type="checkbox" value="1" @if($expense->vat_included) checked @endif />
            </div>
            <div class="mb-3 col-md-4">
                <label class="control-label" for="date_incurred">Date Incurred</label>
                <input class="form-control date-picker" name="date_incurred" value="{{ old('date_incurred', $expense->date_incurred) }}" />
            </div>
            <div class="col-md-12 d-grid gap-2 d-md-block text-end">
                <button class="btn btn-primary" type="submit">
                    Update Expense
                    <i class="fas fa-wrench ms-1"></i>
                </button>
            </div>
        </form>
    </div>
    <form class="row" method="POST" action="{{ url('expenses', $expense) }}">
        @csrf
        @method('DELETE')
        <div class="col-md-3">
            <button class="btn btn-danger w-100">
                Delete
                <i class="fas fa-times ms-1"></i>
            </button>
        </div>
    </form>
</div>
@endsection
