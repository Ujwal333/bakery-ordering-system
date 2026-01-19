@extends('admin.layout')

@section('title', 'Add Logistic Partner')
@section('header', 'Add Logistic Partner')

@section('content')
<div class="card" style="max-width: 600px; margin: auto;">
    <div class="card-body">
        <form action="{{ route('admin.logistics.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Partner Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Speed Delivery" required>
            </div>
            
            <div class="form-group">
                <label>Contact Person</label>
                <input type="text" name="contact_person" class="form-control" placeholder="e.g. John Doe">
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" placeholder="e.g. 98XXXXXXXX">
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Save Partner</button>
                <a href="{{ route('admin.logistics.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
