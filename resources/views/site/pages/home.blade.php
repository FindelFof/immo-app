@extends('site.layouts.app')

@section('title', 'Accueil')

@section('content')
    <!-- Hero Section -->
    @include('site.components.home.hero')


    <!-- About Section -->
    @include('site.components.home.about')

    <!-- Features Section -->
    @include('site.components.home.features')

    <!-- Gallery Section -->
    @include('site.components.home.gallery')

    <!-- Properties Section -->
    @include('site.components.home.properties')

    <!-- Blog Section -->
    @include('site.components.home.blog')

@endsection
