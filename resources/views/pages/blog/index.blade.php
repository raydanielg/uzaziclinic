@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: radial-gradient(900px 380px at 10% 0%, rgba(22,163,74,0.12) 0%, rgba(255,255,255,0) 60%), linear-gradient(180deg, rgba(15,23,42,0.02) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                    <div class="animate__animated animate__fadeInUp">
                        <h1 class="fw-bold mb-2">Clinic Blog</h1>
                        <p class="text-muted mb-0">Health education, clinic updates, and trusted guidance from our medical team.</p>
                    </div>
                    <div class="animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="input-group" style="max-width: 380px;">
                            <span class="input-group-text bg-white" style="border-radius: 12px 0 0 12px;"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control shadow-none" placeholder="Search articles" style="border-left: 0; border-radius: 0 12px 12px 0;">
                        </div>
                    </div>
                </div>

                @php
                    $posts = [
                        [
                            'title' => '5 Daily Habits for a Healthier Life',
                            'category' => 'Health Tips',
                            'excerpt' => 'Simple habits that improve your energy, immunity, and overall wellbeing—starting today.',
                            'image' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=1200&q=60',
                            'read_time' => '4 min read',
                        ],
                        [
                            'title' => 'How to Prepare for Your Clinic Visit',
                            'category' => 'Guidelines',
                            'excerpt' => 'What to bring, what to expect, and how to make the most of your appointment.',
                            'image' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=60',
                            'read_time' => '5 min read',
                        ],
                        [
                            'title' => 'Understanding Preventive Screening',
                            'category' => 'Education',
                            'excerpt' => 'Why early screening matters and how it helps detect conditions before they become severe.',
                            'image' => 'https://images.unsplash.com/photo-1580281658626-ee379f3cce93?auto=format&fit=crop&w=1200&q=60',
                            'read_time' => '6 min read',
                        ],
                        [
                            'title' => 'Nutrition Basics: Building Balanced Meals',
                            'category' => 'Nutrition',
                            'excerpt' => 'A practical guide to meal planning with proteins, vegetables, and healthy carbohydrates.',
                            'image' => 'https://images.unsplash.com/photo-1543362906-acfc16c67564?auto=format&fit=crop&w=1200&q=60',
                            'read_time' => '7 min read',
                        ],
                        [
                            'title' => 'Stress, Sleep, and Recovery',
                            'category' => 'Wellbeing',
                            'excerpt' => 'Improve recovery with better sleep routines and manageable stress-reduction techniques.',
                            'image' => 'https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=1200&q=60',
                            'read_time' => '5 min read',
                        ],
                        [
                            'title' => 'Clinic Updates: Improving Patient Experience',
                            'category' => 'News',
                            'excerpt' => 'We are improving service flow, communication, and waiting time to serve you better.',
                            'image' => 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=1200&q=60',
                            'read_time' => '3 min read',
                        ],
                    ];
                @endphp

                <div class="row g-4">
                    @foreach($posts as $i => $post)
                        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp" style="animation-delay: {{ 0.05 * ($i + 1) }}s;">
                            <div class="card border-0 shadow-sm rounded-4 h-100 blog-card">
                                <div class="blog-img" style="background-image: url('{{ $post['image'] }}');"></div>
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge rounded-pill blog-badge">{{ $post['category'] }}</span>
                                        <span class="text-muted small">{{ $post['read_time'] }}</span>
                                    </div>
                                    <h5 class="fw-bold mb-2">{{ $post['title'] }}</h5>
                                    <p class="text-muted mb-4">{{ $post['excerpt'] }}</p>
                                    <div class="mt-auto">
                                        <a href="#" class="btn btn-success w-100 fw-bold rounded-3 py-2">
                                            Read More
                                            <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.35s;">
                    <div class="card-body p-4 p-md-5">
                        <div class="row align-items-center g-3">
                            <div class="col-md-8">
                                <h5 class="fw-bold mb-2">Want health updates?</h5>
                                <p class="text-muted mb-0">Subscribe in the footer newsletter to receive new articles and clinic announcements.</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="#contact" class="btn btn-outline-success px-4 py-2 fw-bold rounded-3">Contact Us</a>
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
        height: 180px;
        background-size: cover;
        background-position: center;
    }
    .blog-badge {
        background: rgba(22,163,74,0.12);
        color: #16a34a;
        border: 1px solid rgba(22,163,74,0.20);
        font-weight: 700;
        padding: 8px 12px;
    }
</style>
@endsection
