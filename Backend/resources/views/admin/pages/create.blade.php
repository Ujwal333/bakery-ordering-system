@extends('admin.layout')

@section('title', 'Create Page')
@section('header', 'Create Page')
@section('subheader', 'Add new content page')

@section('content')
<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Page Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Slug (URL)</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="e.g. about-us">
            <small class="text-muted">Leave empty to auto-generate from title</small>
            @error('slug') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Content</label>
            <!-- Using simple textarea for now, could be upgraded to WYSIWYG later -->
            <textarea name="content" class="form-control" rows="15" required>{{ old('content') }}</textarea>
            @error('content') <div class="invalid-feedback" style="display:block">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Meta Title (SEO)</label>
            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
        </div>

        <div class="form-group">
            <label class="form-label">Meta Description (SEO)</label>
            <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn btn-primary">Create Page</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline" style="margin-left: 10px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
