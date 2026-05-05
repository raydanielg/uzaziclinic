@extends('layouts.app')

@section('content')
<div class="welcome-page">
    <div class="hero-section animate__animated animate__fadeIn">
        <div class="container text-center">
            <div class="welcome-logo mb-4">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="animate__animated animate__pulse animate__infinite">
            </div>
            <h1 class="display-3 fw-bold mb-3 text-white">{{ config('app.name', 'Laravel') }}</h1>
            <p class="lead mb-5 text-white-50">Karibu kwenye mfumo wetu wa kisasa. Huduma bora, haraka na kwa usalama zaidi.</p>
            
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-lg auth-btn px-5">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Ingia (Login)
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light px-5" style="border-radius: 10px; border-width: 2px;">
                            <i class="fa-solid fa-user-plus me-2"></i>Jisajili
                        </a>
                    @endif
                @else
                    <a href="{{ url('/home') }}" class="btn btn-lg auth-btn px-5">
                        <i class="fa-solid fa-house me-2"></i>Nyumbani (Dashboard)
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <div class="features-section py-5">
        <div class="container">
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm p-4 text-center">
                        <div class="feature-icon mb-3">
                            <i class="fa-solid fa-bolt-lightning fa-3x"></i>
                        </div>
                        <h3>Haraka</h3>
                        <p class="text-muted">Mfumo umejengwa kwa teknolojia ya kisasa zaidi kwa ajili ya kasi ya juu.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm p-4 text-center">
                        <div class="feature-icon mb-3">
                            <i class="fa-solid fa-shield-halved fa-3x"></i>
                        </div>
                        <h3>Salama</h3>
                        <p class="text-muted">Usalama wa taarifa zako ndio kipaumbele chetu namba moja.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm p-4 text-center">
                        <div class="feature-icon mb-3">
                            <i class="fa-solid fa-headset fa-3x"></i>
                        </div>
                        <h3>Msaada</h3>
                        <p class="text-muted">Tunatoa msaada wa kiufundi wakati wowote unapohitaji msaada wetu.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .welcome-page {
        min-height: 100vh;
        background: #f8fafc;
    }
    .hero-section {
        padding: 100px 0;
        background: linear-gradient(135deg, rgba(22, 101, 52, 0.95), rgba(20, 83, 45, 0.9)), 
                    url('{{ asset('african-american-young-patient-with-protective-face-mask-against-covid-resting-bed_482257-26825.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: white;
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    }
    .welcome-logo img {
        max-width: 150px;
        filter: drop-shadow(0 0 20px rgba(255, 255, 255, 0.3));
    }
    .feature-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
    }
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .feature-icon {
        color: #166534;
    }
</style>
@endsection
