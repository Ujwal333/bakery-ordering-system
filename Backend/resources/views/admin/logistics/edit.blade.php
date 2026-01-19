@extends('admin.layout')

@section('title', 'Edit Logistic Partner')
@section('header', 'Edit Logistic Partner')

@section('content')
<div class="card" style="max-width: 600px; margin: auto;">
    <div class="card-body">
        <form action="{{ route('admin.logistics.update', $logistic) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Partner Name</label>
                <input type="text" name="name" class="form-control" value="{{ $logistic->name }}" required>
            </div>
            
            <div class="form-group">
                <label>Contact Person</label>
                <input type="text" name="contact_person" class="form-control" value="{{ $logistic->contact_person }}">
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="{{ $logistic->phone }}">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ $logistic->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$logistic->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Update Partner</button>
                <a href="{{ route('admin.logistics.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
