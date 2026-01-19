@extends('admin.layout')

@section('title', 'Custom Cakes')
@section('header', 'Specialized Cake Requests')
@section('subheader', 'Review and manage custom-built cake orders')

@section('content')
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Ref #</th>
                <th>Customer</th>
                <th>Cake Name</th>
                <th>Price</th>
                <th>Delivery Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cakes as $cake)
            <tr>
                <td><strong>{{ $cake->reference_number }}</strong></td>
                <td>{{ $cake->user->name ?? 'Guest' }}</td>
                <td>{{ $cake->cake_name }}</td>
                <td><strong>Rs {{ number_format($cake->total_price) }}</strong></td>
                <td>{{ $cake->delivery_date->format('M d, Y') }}<br><small>{{ $cake->delivery_time }}</small></td>
                <td>
                    <span class="badge badge-{{ $cake->status }}">
                        {{ str_replace('_', ' ', $cake->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.custom-cakes.show', $cake) }}" class="btn btn-outline" style="padding: 5px 12px; font-size: 13px;">
                        <i class="fas fa-eye"></i> Details
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
