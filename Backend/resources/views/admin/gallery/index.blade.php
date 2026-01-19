@extends('admin.layout')

@section('title', 'Gallery')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gallery</h2>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Image
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
            <div class="row">
                @forelse($galleries as $image)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="{{ $image->title }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $image->title }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($image->description, 60) }}</p>
                                @if($image->category)
                                    <span class="badge badge-info">{{ $image->category }}</span>
                                @endif
                                @if($image->is_featured)
                                    <span class="badge badge-warning">Featured</span>
                                @endif
                            </div>
                            <div class="card-footer bg-white">
                                <div class="btn-group btn-group-sm w-100">
                                    <a href="{{ route('admin.gallery.edit', $image) }}" class="btn btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.gallery.toggle-featured', $image) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-{{ $image->is_featured ? 'warning' : 'secondary' }}" title="Toggle Featured">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" 
                                          onsubmit="return confirm('Delete this image?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-4x text-muted mb-3"></i>
                            <p class="text-muted">No images in gallery. <a href="{{ route('admin.gallery.create') }}">Upload your first image</a></p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $galleries->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
