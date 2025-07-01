@extends('layouts.app')

@section('content')
    <h2>Add Customer</h2>
    <form method="POST" action="{{ route('customers.store') }}">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone" class="form-control" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="{{ old('email') }}">
        </div>

        <button class="btn btn-success">Save</button>
    </form>
@endsection
