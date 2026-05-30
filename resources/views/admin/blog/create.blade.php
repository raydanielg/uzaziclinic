@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-plus me-2"></i>New Blog Post</h4>
            <p class="text-muted small mb-0">Create a new article for the UzaziClinic blog</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.blog.index') }}" class="btn btn-light fw-semibold rounded-2 shadow-sm px-4">
                <i class="fa-solid fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <form action="{{ route('admin.blog.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label small fw-bold">Title *</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g., Understanding Reproductive Health">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Category</label>
                        <input type="text" name="category" class="form-control" placeholder="e.g., Family Planning">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Author</label>
                        <input type="text" name="author" class="form-control" placeholder="UzaziClinic Team" value="UzaziClinic Team">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Read Time</label>
                        <input type="text" name="read_time" class="form-control" placeholder="5 min read">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Image URL</label>
                        <input type="text" name="image" class="form-control" placeholder="https://images.unsplash.com/...">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Tags (comma separated)</label>
                        <input type="text" name="tags" class="form-control" placeholder="reproductive health, family planning, women health">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Excerpt</label>
                        <textarea name="excerpt" rows="2" class="form-control" placeholder="Brief summary of the article..."></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Content</label>
                        <textarea name="content" rows="15" class="form-control font-monospace" placeholder="Write your article content here. Use <h5> for headings, <p> for paragraphs, <ul>/<li> for lists."></textarea>
                        <div class="form-text small">HTML is supported. Use &lt;h5&gt; for section headings, &lt;p&gt; for paragraphs, &lt;ul&gt;/&lt;li&gt; for lists, &lt;strong&gt; for bold text.</div>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary fw-semibold rounded-2 px-4">
                        <i class="fa-solid fa-save me-2"></i>Save Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
