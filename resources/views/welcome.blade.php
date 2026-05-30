@extends('layouts.landing')

@section('content')
    @include('landing.sections.hero')
    @include('landing.sections.features')
    @include('landing.sections.services')
    @include('landing.sections.appointments')
    @include('landing.sections.contact')
@endsection

