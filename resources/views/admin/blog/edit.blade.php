@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-pen me-2"></i>Edit Blog Post</h4>
            <p class="text-muted small mb-0">Update article content and settings</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-light fw-semibold rounded-2 shadow-sm px-4">
                <i class="fa-solid fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <form action="{{ route('admin.blog.update', $blog) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label small fw-bold">Title *</label>
                        <input type="text" name="title" class="form-control" required value="{{ $blog->title }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Category</label>
                        <input type="text" name="category" class="form-control" value="{{ $blog->category }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Author</label>
                        <input type="text" name="author" class="form-control" value="{{ $blog->author }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Read Time</label>
                        <input type="text" name="read_time" class="form-control" value="{{ $blog->read_time }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ $blog->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $blog->status === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Image URL</label>
                        <input type="text" name="image" class="form-control" value="{{ $blog->image }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Tags (comma separated)</label>
                        <input type="text" name="tags" class="form-control" value="{{ $blog->tags }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Excerpt</label>
                        <textarea name="excerpt" rows="2" class="form-control">{{ $blog->excerpt }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Content</label>
                        <textarea name="content" rows="15" class="form-control font-monospace">{{ $blog->content }}</textarea>
                        <div class="form-text small">HTML is supported. Use &lt;h5&gt; for section headings, &lt;p&gt; for paragraphs, &lt;ul&gt;/&lt;li&gt; for lists, &lt;strong&gt; for bold text.</div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary fw-semibold rounded-2 px-4">
                        <i class="fa-solid fa-save me-2"></i>Update Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
