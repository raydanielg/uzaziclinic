@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                    <div class="animate__animated animate__fadeInUp">
                        <h1 class="fw-bold mb-2">UzaziClinic Blog</h1>
                        <p class="text-muted mb-0">Reproductive health education, family planning guidance, and trusted insights from our specialists.</p>
                    </div>
                    <div class="animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ url('/blog') }}" class="btn btn-sm rounded-pill fw-bold {{ !request('category') ? 'btn-success' : 'btn-outline-success' }}">All</a>
                            @foreach($categories as $cat)
                                <a href="{{ url('/blog?category=' . urlencode($cat)) }}" class="btn btn-sm rounded-pill fw-bold {{ request('category') === $cat ? 'btn-success' : 'btn-outline-success' }}">{{ $cat }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if($blogs->count() > 0)
                    <div class="row g-4">
                        @foreach($blogs as $i => $post)
                            <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp" style="animation-delay: {{ 0.05 * ($i + 1) }}s;">
                                <div class="card border-0 shadow-sm rounded-4 h-100 blog-card">
                                    <div class="blog-img position-relative" style="background-image: url('{{ $post->image ?? 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1200&q=60' }}');">
                                        <span class="badge blog-badge position-absolute top-0 start-0 m-3">{{ $post->category ?? 'General' }}</span>
                                    </div>
                                    <div class="card-body p-4 d-flex flex-column">
                                        <div class="d-flex align-items-center text-muted small mb-2 gap-3">
                                            <span><i class="fas fa-user me-1"></i>{{ $post->author }}</span>
                                            <span><i class="fas fa-clock me-1"></i>{{ $post->read_time ?? '5 min read' }}</span>
                                            <span><i class="fas fa-calendar me-1"></i>{{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</span>
                                        </div>
                                        <h5 class="fw-bold mb-2 blog-title">{{ $post->title }}</h5>
                                        <p class="text-muted mb-4 small">{{ $post->excerpt }}</p>
                                        <div class="mt-auto">
                                            <a href="{{ url('/blog/' . $post->slug) }}" class="btn btn-success w-100 fw-bold rounded-3 py-2">
                                                Read More <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 d-flex justify-content-center">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/5995/5995032.png" alt="No posts" width="80" class="mb-3 opacity-50">
                        <h5 class="fw-bold text-muted">No blog posts yet</h5>
                        <p class="text-muted small">Check back soon for reproductive health articles and updates.</p>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.35s;">
                    <div class="card-body p-4 p-md-5">
                        <div class="row align-items-center g-3">
                            <div class="col-md-8">
                                <h5 class="fw-bold mb-2">Want health updates?</h5>
                                <p class="text-muted mb-0">Subscribe in the footer newsletter to receive new articles and clinic announcements.</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="{{ url('/contact-us') }}" class="btn btn-outline-success px-4 py-2 fw-bold rounded-3">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
    .blog-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        overflow: hidden;
    }
    .blog-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    }
    .blog-img {
        height: 200px;
        background-size: cover;
        background-position: center;
    }
    .blog-badge {
        background: rgba(22,163,74,0.92);
        color: white;
        font-weight: 600;
        padding: 6px 14px;
        font-size: 0.75rem;
    }
    .blog-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .pagination {
        gap: 4px;
    }
    .pagination .page-link {
        border-radius: 8px;
        border: none;
        padding: 8px 14px;
        font-weight: 600;
        color: #475569;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .pagination .page-item.active .page-link {
        background: #16a34a;
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        opacity: 0.4;
    }
</style>
@endsection