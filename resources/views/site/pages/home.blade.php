@extends('site.layouts.app')

@section('title', 'Accueil')

@section('content')
    <!-- Hero Section -->
    @include('site.components.home.hero')

    <!-- Search Tabs -->
    @include('site.components.home.search-tabs')

    <!-- About Section -->
    @include('site.components.home.about')

    <!-- Features Section -->
    @include('site.components.home.features')

    <!-- Gallery Section -->
    @include('site.components.home.gallery')

    <!-- Properties Section -->
    @include('site.components.home.properties')

    <!-- Location Section -->
    @include('site.components.home.location')

    <!-- Testimonial Section -->
    @include('site.components.home.testimonial')

    <!-- Blog Section -->
    <!-- @include('site.components.home.blog') -->

    <!-- Contact Section -->
    @include('site.components.home.contact')

    <!-- CTA Section -->
    @include('site.components.home.cta')
@endsection
