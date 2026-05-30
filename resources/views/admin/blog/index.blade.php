@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h4 class="fw-bold mb-0"><i class="fa-solid fa-newspaper me-2"></i>Blog Management</h4>
            <p class="text-muted small mb-0">Manage blog posts and articles</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.blog.create') }}" class="btn btn-primary fw-semibold rounded-2 shadow-sm px-4">
                <i class="fa-solid fa-plus me-2"></i>New Post
            </a>
        </div>
    </div>

    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $post)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($post->image)
                                        <div class="rounded-2 flex-shrink-0" style="width: 40px; height: 40px; background: url('{{ $post->image }}') center/cover;"></div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold small">{{ Str::limit($post->title, 50) }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $post->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-success rounded-pill">{{ $post->category ?? 'Uncategorized' }}</span>
                            </td>
                            <td>
                                <div class="small">{{ $post->author }}</div>
                            </td>
                            <td>
                                @if($post->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">{{ $post->published_at ? $post->published_at->format('M d, Y') : '—' }}</div>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ url('/blog/' . $post->slug) }}" class="btn btn-sm btn-light rounded-2" title="View" target="_blank">
                                        <i class="fa-solid fa-eye text-info"></i>
                                    </a>
                                    <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-sm btn-light rounded-2" title="Edit">
                                        <i class="fa-solid fa-pen text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-2" onclick="return confirm('Delete this blog post?')" title="Delete">
                                            <i class="fa-solid fa-trash text-rose"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-newspaper fs-2 opacity-25 d-block mb-2"></i>
                                No blog posts yet. <a href="{{ route('admin.blog.create') }}">Create your first post</a>
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
