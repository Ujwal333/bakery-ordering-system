@extends('admin.layout')

@section('title', 'Edit Page')
@section('header', 'Edit Page')
@section('subheader', 'Update content for: ' . $page->title)

@section('content')
<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Page Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required>
            @error('title') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Slug (URL)</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}">
            @error('slug') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="15" required>{{ old('content', $page->content) }}</textarea>
            @error('content') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Meta Title (SEO)</label>
            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
        </div>

        <div class="form-group">
            <label class="form-label">Meta Description (SEO)</label>
            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ old('is_active', $page->is_active) == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active', $page->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Update Page</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline" style="margin-left: 10px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
