@extends('admin.layout')

@section('title', 'Dine-In Management')
@section('header', 'Dine-In & Tables')
@section('subheader', 'Manage restaurant tables and real-time availability')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
    @foreach($tables as $table)
    <div class="card" style="border-left: 5px solid {{ $table->status === 'available' ? '#60bb46' : ($table->status === 'occupied' ? '#e74c3c' : '#f39c12') }};">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h2 style="margin: 0;">Table {{ $table->table_number }}</h2>
                <span class="badge badge-{{ $table->status === 'available' ? 'confirmed' : ($table->status === 'occupied' ? 'delivered' : 'pending') }}" style="margin-top: 5px; display: inline-block;">
                    {{ strtoupper($table->status) }}
                </span>
            </div>
            <div style="font-size: 2rem;">🪑</div>
        </div>
        
        <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
            @if($table->status === 'occupied' && $table->current_order_id)
                <p style="margin-bottom: 15px;">
                    <strong>Current Order:</strong><br>
                    <a href="{{ route('admin.orders.show', $table->current_order_id) }}" style="color: var(--primary); font-weight: bold;">
                        View Order #{{ $table->current_order_id }}
                    </a>
                </p>
                <form action="{{ route('admin.dinein.free', $table) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="width: 100%; justify-content: center; color: #60bb46; border-color: #60bb46;">
                        <i class="fas fa-check"></i> Mark as Available
                    </button>
                </form>
            @else
                <form action="{{ route('admin.dinein.update-status', $table) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group" style="margin-bottom: 10px;">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="available" {{ $table->status === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ $table->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="reserved" {{ $table->status === 'reserved' ? 'selected' : '' }}>Reserved</option>
                        </select>
                    </div>
                </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
