@extends('admin.layout')

@section('title', 'Cake Customization Options')
@section('header', 'Cake Options')
@section('subheader', 'Manage types, sizes, flavors, and frostings')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="margin:0;">All Options</h3>
        <a href="{{ route('admin.cake-options.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Option
        </a>
    </div>

    @foreach($options as $type => $opts)
        <div style="margin-bottom: 40px;">
            <h4 style="color: var(--primary); text-transform: capitalize; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">
                {{ str_replace('_', ' ', $type) }}s
            </h4>
            <table>
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Name</th>
                        <th>Price (Rs)</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($opts as $opt)
                    <tr>
                        <td>
                            @if($opt->image_path)
                                <img src="{{ '/storage/' . $opt->image_path }}" alt="" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                            @else
                                <div style="width: 40px; height: 40px; background: #eee; border-radius: 4px;"></div>
                            @endif
                        </td>
                        <td>{{ $opt->name }}</td>
                        <td>{{ number_format($opt->price) }}</td>
                        <td>
                            <span style="font-weight: 600; color: {{ $opt->stock < 10 ? 'red' : 'inherit' }}">
                                {{ $opt->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $opt->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $opt->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.cake-options.edit', $opt) }}" class="btn btn-outline btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.cake-options.destroy', $opt) }}" method="POST" onsubmit="return confirm('Delete this option?')" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger-outline btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>
@endsection
