<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.head')
</head>
<body class="homepage1-body">

<!-- Préchargeur -->
@include('layouts.partials.preloader')

<!-- Progression de la page -->
<div class="paginacontainer">
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
        </svg>
    </div>
</div>

<!-- Header -->
@include('layouts.partials.header')

<!-- Contenu principal -->
@yield('content')

<!-- Footer -->
@include('layouts.partials.footer')

<!-- Scripts -->
@include('layouts.partials.scripts')
@stack('scripts')
</body>
</html>
