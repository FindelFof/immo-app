@extends('layouts.app')

@section('title', 'GFI Co-Immo - Accueil')

@section('body-class', 'homepage1-body')

@section('content')
<!--===== SECTION HÉRO =======-->
<div class="hero1-section-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="header-main-content heading1">
          <img src="{{ asset('assets/img/elements/star1.png') }}" alt="" class="star1 keyframe5">
          <img src="{{ asset('assets/img/elements/star1.png') }}" alt="" class="star2 keyframe5">
          <h1 class="text-anim">Des Propriétés Exceptionnelles Dans <br class="d-lg-block d-none"> Les Meilleurs Quartiers</h1>
        </div>
      </div>
      <div class="space74 d-lg-block d-none"></div>
      <div class="space30 d-lg-none d-block"></div>
      <div class="col-lg-3">
        <div class="header-pera heading1">
          <img src="{{ asset('assets/img/elements/star2.png') }}" alt="" class="star3 keyframe5">
          <p class="text-anim">Découvrez une large gamme de propriétés exclusives adaptées à votre style de vie et à vos préférences. Que vous recherchiez un appartement confortable au cœur de la ville ou une villa spacieuse.</p>
          <div class="video-btn-area">
            <a href="https://www.youtube.com/watch?v=Y8XpQpW5OVY" class="popup-youtube">
              <span class="video"><i class="fa-solid fa-play"></i></span>
              <span class="play">Voir la vidéo</span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-7"></div>
      <div class="col-lg-2">
        <div class="all-counter-area">
          <div class="counter-area" data-aos="fade-left" data-aos-duration="800">
            <h2><span class="counter">5.0</span></h2>
            <p>Note moyenne</p>
          </div>
          <div class="space60"></div>
          <div class="counter-area" data-aos="fade-left" data-aos-duration="1000">
            <h2><span class="counter">89</span>k+</h2>
            <p>Biens gérés</p>
          </div>
          <div class="space60"></div>
          <div class="counter-area" data-aos="fade-left" data-aos-duration="1100">
            <h2><span class="counter">40</span>M+</h2>
            <p>Total des ventes</p>
          </div>
          <div class="space60"></div>
          <div class="counter-area" data-aos="fade-left" data-aos-duration="1200">
            <img src="{{ asset('assets/img/all-images/others-img1.png') }}" alt="">
            <div class="space16"></div>
            <h2><span class="counter">12</span>K+</h2>
            <p>Clients satisfaits</p>
          </div>
        </div>
      </div>
      <div class="col-lg-10 m-auto">
        <div class="header-images text-center">
          <div class="img1" data-aos="fade-down" data-aos-duration="1200">
            <img src="{{ asset('assets/img/all-images/header-img1.png') }}" alt="">
          </div>
          <p class="aniamtion-key-1"><img src="{{ asset('assets/img/icons/logo-icon.svg') }}" alt="">Plus de 100 nouveaux biens disponibles</p>

          <div class="circle-area">
           <a href="#">
            <img src="{{ asset('assets/img/elements/circle.png') }}" alt="" class="keyframe5 circle">
            <img src="{{ asset('assets/img/icons/arrow2.svg') }}" alt="" class="arrow2"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== FIN SECTION HÉRO =======-->

{{-- @include('partials.home.tabs') --}}

<!--===== SECTION À PROPOS =======-->
<div class="about1-section-area sp1">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <div class="about-images-area">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="space90"></div>
              <div class="author-images">
                <div class="img1 image-anime reveal">
                  <img src="{{ asset('assets/img/all-images/about-img1.png') }}" alt="">
                </div>
                <div class="city-area">
                  <div class="icons">
                    <img src="{{ asset('assets/img/icons/logo-icon1.svg') }}" alt="">
                  </div>
                  <div class="content">
                    <a href="">Paris</a>
                    <p>Bienvenue chez GFI Co-Immo, votre partenaire immobilier de confiance.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="author-images">
                <div class="img1 image-anime reveal">
                  <img src="{{ asset('assets/img/all-images/about-img2.png') }}" alt="">
                </div>
                <div class="space30"></div>
                <div class="img1 image-anime reveal">
                  <img src="{{ asset('assets/img/all-images/about-img3.png') }}" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="about-content-header heading2">
          <h5 class="text-anim"><img src="{{ asset('assets/img/icons/logo-icon1.svg') }}" alt="">À propos de GFI Co-Immo</h5>
          <h2 class="text-anim">Des professionnels expérimentés à votre service</h2>
          <div class="space24"></div>
          <p class="text-anim">Bienvenue chez GFI Co-Immo, où notre passion pour l'immobilier et notre dévouement à la satisfaction client convergent pour créer une expérience d'achat immobilier inégalée. Fondée en 2015, notre entreprise s'est développée pour devenir une agence immobilière de premier plan.</p>
          <div class="space32"></div>
          <div class="btn-area1 text-anim">
            <a href="" class="header-btn1">En savoir plus <img src="{{ asset('assets/img/icons/arrow1.svg') }}" alt=""></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== FIN SECTION À PROPOS =======-->

@include('partials.home.featured-properties')
@include('partials.home.gallery')
@include('partials.home.properties')
@include('partials.home.locations')
@include('partials.home.testimonials')
@include('partials.home.blog')
@include('partials.home.cta')
@endsection
