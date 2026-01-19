@extends('admin.layout')

@section('title', 'Payment Methods')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Payment Methods</h2>
        <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Payment Method
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>QR Code</th>
                            <th>Account Info</th>
                            <th>Extra Charge</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paymentMethods as $method)
                            <tr>
                                <td>{{ $method->sort_order }}</td>
                                <td>
                                    @if($method->logo_url)
                                        <img src="{{ asset('storage/' . $method->logo_url) }}" alt="{{ $method->name }}" style="height: 30px;">
                                    @else
                                        <i class="fas fa-credit-card fa-2x text-muted"></i>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $method->display_name }}</strong><br>
                                    <small class="text-muted">{{ $method->description }}</small>
                                </td>
                                <td><code>{{ $method->code }}</code></td>
                                <td>
                                    @if($method->qr_code_path)
                                        <a href="{{ asset('storage/' . $method->qr_code_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $method->qr_code_path) }}" alt="QR Code" style="height: 50px; width: 50px; object-fit: cover;">
                                        </a>
                                    @else
                                        <span class="text-muted">No QR</span>
                                    @endif
                                </td>
                                <td>
                                    @if($method->account_number)
                                        <strong>{{ $method->account_name }}</strong><br>
                                        <small>{{ $method->account_number }}</small>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $method->formatted_extra_charge }}</td>
                                <td>
                                    <form action="{{ route('admin.payment-methods.toggle-status', $method) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-{{ $method->is_active ? 'success' : 'secondary' }}">
                                            {{ $method->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.payment-methods.edit', $method) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this payment method?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No payment methods found. <a href="{{ route('admin.payment-methods.create') }}">Add one now</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
