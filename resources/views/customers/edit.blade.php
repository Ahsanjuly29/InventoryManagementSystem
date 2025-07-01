@extends('layouts.app')

@section('content')
    <h2>Edit Customer</h2>

    <form method="POST" action="{{ route('customers.update', $customer) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="{{ old('email', $customer->email) }}">
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
@endsection
