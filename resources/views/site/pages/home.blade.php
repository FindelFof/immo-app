@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <!-- Hero Section -->
    @include('components.home.hero')

    <!-- Search Tabs -->
    @include('components.home.search-tabs')

    <!-- About Section -->
    @include('components.home.about')

    <!-- Features Section -->
    @include('components.home.features')

    <!-- Gallery Section -->
    @include('components.home.gallery')

    <!-- Properties Section -->
    @include('components.home.properties')

    <!-- Location Section -->
    @include('components.home.location')

    <!-- Testimonial Section -->
    @include('components.home.testimonial')

    <!-- Blog Section -->
    @include('components.home.blog')

    <!-- Contact Section -->
    @include('components.home.contact')

    <!-- CTA Section -->
    @include('components.home.cta')
@endsection
