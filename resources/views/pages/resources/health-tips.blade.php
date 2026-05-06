@extends('layouts.landing')

@section('content')
<section class="py-5" style="background: linear-gradient(180deg, rgba(22,163,74,0.08) 0%, rgba(255,255,255,0) 55%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4 animate__animated animate__fadeInUp">
                    <h1 class="fw-bold mb-2">Health Tips</h1>
                    <p class="text-muted mb-0">Practical tips to help you stay healthy every day.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.05s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Nutrition</h5>
                                <p class="text-muted mb-3">Build healthy habits with balanced meals and smart choices.</p>
                                <ul class="text-muted mb-0">
                                    <li>Drink enough water daily</li>
                                    <li>Choose whole grains and vegetables</li>
                                    <li>Limit excess sugar and salt</li>
                                    <li>Eat consistent meals to support energy</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Exercise</h5>
                                <p class="text-muted mb-3">Keep your body strong with safe and regular activity.</p>
                                <ul class="text-muted mb-0">
                                    <li>Start with 20–30 minutes a day</li>
                                    <li>Include stretching for flexibility</li>
                                    <li>Keep a consistent routine</li>
                                    <li>Consult a clinician if you have chronic conditions</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.15s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Sleep</h5>
                                <p class="text-muted mb-3">Quality sleep supports immunity and long-term health.</p>
                                <ul class="text-muted mb-0">
                                    <li>Maintain a consistent sleep schedule</li>
                                    <li>Avoid screens before bedtime</li>
                                    <li>Create a calm sleep environment</li>
                                    <li>Reduce caffeine late in the day</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2">Preventive Care</h5>
                                <p class="text-muted mb-3">Prevention helps detect conditions early and improve outcomes.</p>
                                <ul class="text-muted mb-0">
                                    <li>Attend routine check-ups</li>
                                    <li>Follow vaccination guidance</li>
                                    <li>Monitor blood pressure and blood sugar</li>
                                    <li>Seek help early when symptoms start</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.25s;">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-2">Remember</h5>
                        <p class="text-muted mb-0">These tips are for general education. If you have symptoms or concerns, contact the clinic or book an appointment.</p>
                        <div class="mt-3">
                            <a href="{{ route('support.help-center') }}" class="btn btn-success fw-bold rounded-3 px-4 py-2">Visit Help Center</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
