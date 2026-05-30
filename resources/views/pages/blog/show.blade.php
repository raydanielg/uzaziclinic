@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <nav aria-label="breadcrumb" class="mb-4 animate__animated animate__fadeInUp">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/blog') }}" class="text-decoration-none text-muted">Blog</a></li>
                        <li class="breadcrumb-item active fw-bold" aria-current="page">{{ Str::limit($blog->title, 40) }}</li>
                    </ol>
                </nav>

                <div class="row g-5">
                    <div class="col-lg-8">
                        <article class="animate__animated animate__fadeInUp">
                            <div class="mb-4">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: rgba(22,163,74,0.12); color: #16a34a;">{{ $blog->category ?? 'General' }}</span>
                                </div>
                                <h1 class="fw-bold display-6 mb-3" style="font-family: 'Georgia', serif;">{{ $blog->title }}</h1>
                                <div class="d-flex flex-wrap align-items-center text-muted small gap-4 mb-4">
                                    <span><i class="fas fa-user-circle me-2 text-green-600"></i>{{ $blog->author }}</span>
                                    <span><i class="fas fa-calendar me-2 text-green-600"></i>{{ $blog->published_at ? $blog->published_at->format('F d, Y') : '' }}</span>
                                    <span><i class="fas fa-clock me-2 text-green-600"></i>{{ $blog->read_time ?? '5 min read' }}</span>
                                    <span><i class="fas fa-tag me-2 text-green-600"></i>{{ $blog->category }}</span>
                                </div>
                            </div>

                            @if($blog->image)
                                <div class="blog-hero-img rounded-4 mb-4 shadow-sm" style="background-image: url('{{ $blog->image }}');"></div>
                            @endif

                            <div class="card border-0 shadow-sm rounded-4 mb-4">
                                <div class="card-body p-4 p-md-5">
                                    <div class="blog-content text-muted">
                                        {!! nl2br($blog->content) !!}
                                    </div>
                                </div>
                            </div>

                            @if($blog->tags)
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    @foreach(explode(',', $blog->tags) as $tag)
                                        <span class="badge bg-light text-dark rounded-pill px-3 py-2 small">#{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: rgba(22,163,74,0.04); border: 1px solid rgba(22,163,74,0.12) !important;">
                                <div class="card-body p-4 p-md-5">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-8">
                                            <h5 class="fw-bold mb-1">Need personalized guidance?</h5>
                                            <p class="text-muted mb-0 small">Book a confidential consultation with our reproductive health specialists at UzaziClinic.</p>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <a href="{{ route('appointments') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2">Book Appointment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-4 mb-4">
                                <a href="{{ url('/blog') }}" class="btn btn-outline-success rounded-3 px-4 py-2 fw-bold">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Blog
                                </a>
                                <div class="d-flex gap-2">
                                    <span class="text-muted small fw-bold me-2 d-flex align-items-center">Share:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="social-share-btn" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="social-share-btn" title="Share on Twitter"><i class="fab fa-twitter"></i></a>
                                    <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . url()->current()) }}" target="_blank" class="social-share-btn" title="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </div>
                        </article>

                        @if($relatedPosts->count() > 0)
                            <div class="mt-5">
                                <h5 class="fw-bold mb-4">Related Articles</h5>
                                <div class="row g-4">
                                    @foreach($relatedPosts as $related)
                                        <div class="col-md-4">
                                            <a href="{{ url('/blog/' . $related->slug) }}" class="text-decoration-none">
                                                <div class="card border-0 shadow-sm rounded-4 h-100 related-card">
                                                    <div class="related-img" style="background-image: url('{{ $related->image ?? 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1200&q=60' }}');"></div>
                                                    <div class="card-body p-3">
                                                        <span class="badge bg-light text-success rounded-pill px-2 py-1 mb-2 small">{{ $related->category }}</span>
                                                        <h6 class="fw-bold mb-0 text-dark small related-title">{{ $related->title }}</h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <div class="position-sticky" style="top: 100px;">
                            <div class="card border-0 shadow-sm rounded-4 mb-4">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold mb-3"><i class="fas fa-newspaper me-2 text-green-600"></i>Recent Posts</h6>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($recentPosts as $recent)
                                            <li class="mb-3">
                                                <a href="{{ url('/blog/' . $recent->slug) }}" class="text-decoration-none d-flex gap-3">
                                                    <div class="recent-thumb rounded-2 flex-shrink-0" style="background-image: url('{{ $recent->image ?? 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=100&q=60' }}');"></div>
                                                    <div>
                                                        <div class="small fw-bold text-dark recent-title-side">{{ $recent->title }}</div>
                                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $recent->published_at ? $recent->published_at->format('M d, Y') : '' }}</div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm rounded-4 mb-4">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold mb-3"><i class="fas fa-layer-group me-2 text-green-600"></i>Categories</h6>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($categories as $cat)
                                            <li class="mb-2">
                                                <a href="{{ url('/blog?category=' . urlencode($cat)) }}" class="text-decoration-none d-flex justify-content-between align-items-center py-1 category-link">
                                                    <span class="small"><i class="fas fa-chevron-right me-2" style="font-size: 0.6rem; color: #16a34a;"></i>{{ $cat }}</span>
                                                    <span class="badge bg-light text-muted small">{{ \App\Models\Blog::published()->where('category', $cat)->count() }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, rgba(22,163,74,0.06) 0%, rgba(22,163,74,0.12) 100%); border: 1px solid rgba(22,163,74,0.15) !important;">
                                <div class="card-body p-4 text-center">
                                    <div class="mb-3">
                                        <img src="{{ asset('logo.png') }}" alt="UzaziClinic" height="50">
                                    </div>
                                    <h6 class="fw-bold mb-2">Visit UzaziClinic</h6>
                                    <p class="text-muted small mb-3">Mlimani City, Dar es Salaam<br>+255 678 233 736</p>
                                    <a href="{{ route('appointments') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2 w-100">Book Appointment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .blog-hero-img {
        height: 380px;
        background-size: cover;
        background-position: center;
    }
    .blog-content h5 {
        margin-top: 1.8rem;
        margin-bottom: 0.8rem;
        color: #1e293b;
    }
    .blog-content p {
        line-height: 1.8;
        margin-bottom: 1rem;
    }
    .blog-content ul {
        padding-left: 1.2rem;
        margin-bottom: 1rem;
    }
    .blog-content ul li {
        margin-bottom: 0.5rem;
        line-height: 1.7;
    }
    .blog-content strong {
        color: #1e293b;
    }
    .social-share-btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f1f5f9;
        color: #475569;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .social-share-btn:hover {
        background: #16a34a;
        color: white;
        transform: translateY(-2px);
    }
    .related-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.10);
    }
    .related-img {
        height: 120px;
        background-size: cover;
        background-position: center;
        border-radius: 12px 12px 0 0;
    }
    .related-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .recent-thumb {
        width: 56px;
        height: 56px;
        background-size: cover;
        background-position: center;
    }
    .recent-title-side {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-size: 0.8rem;
    }
    .category-link {
        color: #475569;
        transition: all 0.2s ease;
    }
    .category-link:hover {
        color: #16a34a;
        transform: translateX(5px);
    }
    @media (max-width: 768px) {
        .blog-hero-img {
            height: 220px;
        }
    }
</style>
@endsection