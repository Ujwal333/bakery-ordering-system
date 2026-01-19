@extends('admin.layout')

@section('title', 'Manage Page Content')

@section('content')
<div class="content-header">
    <h1>Page Content Management</h1>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        @forelse($contents as $pageKey => $items)
            <h2 class="mb-3" style="text-transform: capitalize; border-bottom: 2px solid #eee; padding-bottom: 10px;">{{ $pageKey }} Page</h2>
            
            @foreach($items as $item)
            <div class="card mb-4" style="border: 1px solid #eee; box-shadow: none;">
                <div class="card-body">
                    <h4 class="card-title">{{ ucfirst($item->section_key) }} Section</h4>
                    <form action="{{ route('admin.page-contents.update', $item) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $item->title }}">
                                </div>
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea class="form-control" name="content" rows="4">{{ $item->content }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Image</label>
                                    @if($item->image_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $item->image_path) }}" style="max-width: 100%; height: auto; border-radius: 5px;">
                                        <div class="mt-2">
                                            <input type="checkbox" name="remove_image" id="remove_image_{{ $item->id }}" value="1">
                                            <label for="remove_image_{{ $item->id }}" style="color: #dc3545; font-size: 13px;">Remove Image</label>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="file" class="form-control-file" name="image">
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Update Section</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        @empty
            <div class="alert alert-info">No editable content found. Please import the database SQL first.</div>
        @endforelse
    </div>
</div>
@endsection
