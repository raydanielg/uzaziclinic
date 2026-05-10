@extends('layouts.app')

@section('content')
<div class="pharmacist-profile py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="fw-bold mb-4 text-primary">My Profile</h4>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                                <input type="text" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                                <input type="email" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ Auth::user()->email }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Phone Number</label>
                                <input type="text" class="form-control rounded-1 border-light bg-light shadow-none" value="{{ Auth::user()->phone ?? 'N/A' }}">
                            </div>
                            <div class="col-12 text-end pt-3">
                                <button type="submit" class="btn btn-primary rounded-1 px-5 fw-bold border-0">Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
