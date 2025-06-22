<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('site.layouts.partials.head')

    {{-- Ajout de la police Poppins depuis Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* On applique la nouvelle police à tout le site pour une cohérence parfaite */
        body, h1, h2, h3, h4, h5, h6, p, a, span, div, li, input, button, textarea, label {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Styles personnalisés pour les flèches du carrousel "Nos réalisations" */
        .realisation-slider .owl-nav {
            text-align: center;
            margin-top: 40px; /* Espace au-dessus des flèches */
            margin-bottom: 20px; /* Espace entre les flèches et le bouton "Explorer" */
        }

        .realisation-slider .owl-nav button.owl-prev,
        .realisation-slider .owl-nav button.owl-next {
            display: inline-block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            margin: 0 10px;
            border-radius: 50%;
            background: var(--primary-color) !important;
            color: white !important;
            font-size: 1rem !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .realisation-slider .owl-nav button.owl-prev:hover,
        .realisation-slider .owl-nav button.owl-next:hover {
            background: var(--secondary-color) !important;
            transform: translateY(-3px);
        }
    </style>
</head>
<body class="homepage1-body">

<!-- Préchargeur -->
@include('site.layouts.partials.preloader')

<!-- Progression de la page -->
<div class="paginacontainer">
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
        </svg>
    </div>
</div>

<!-- Header -->
@include('site.layouts.partials.header')

<!-- Contenu principal -->
@yield('content')

<!-- Footer -->
@include('site.layouts.partials.footer')

<!-- Scripts -->
@include('site.layouts.partials.scripts')
@stack('scripts')

<!-- Script d'initialisation pour le carrousel des réalisations (MIS À JOUR) -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof $ !== 'undefined') {
        $('.realisation-slider').owlCarousel({
            loop: true,
            margin: 30,
            nav: true, // On active les flèches
            navText: ["<i class='fa-solid fa-arrow-left'></i>", "<i class='fa-solid fa-arrow-right'></i>"], // On définit les icônes
            dots: false, // On cache les points car on a maintenant des flèches
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        });
    }
});
</script>

</body>
</html>
