@extends('site.layouts.app')

@section('title', 'Contactez-nous')

@section('content')

<!--===== HERO AREA STARTS =======-->
<div class="inner2-section-area" style="background-image: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('https://images.pexels.com/photos/259588/pexels-photo-259588.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2') !important; background-size: cover !important; background-position: center !important; padding: 8rem 0 !important;">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 m-auto">
                <div class="inner-header heading1 text-center">
                    <a href="/" style="color: #000000 !important">Accueil <i class="fa-solid fa-angle-right"></i>  <span> Contact </span></a>
                    <div class="space20"></div>
                    <h2> Contactez-nous </h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== CONTACT AREA STARTS =======-->
<div class="contact-inner-section-area sp1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="contact-inner-header heading2">
                    <h5><img src="assets/img/icons/logo-icon1.svg" alt="">Contactez-nous</h5>
                    <h2>Prenez contact avec nous : votre partenaire immobilier</h2>
                    <div class="space16"></div>
                    <p>Nous sommes là pour vous assister dans tous vos besoins immobiliers. Que vous souhaitiez acheter, vendre, louer ou investir, notre équipe expérimentée est prête à vous fournir le soutien et l'expertise dont vous avez besoin.</p>
                    <ul> 
                        <li><a href="#"><img src="assets/img/icons/location1.svg" alt="">LT 18 IL 1 AKOUEDO TRIANGLE, Quartier 09 Secteur Palmeraie, Abidjan, Côte d'Ivoire</a></li>
                        <li><a href="tel:+2250700122662"><img src="assets/img/icons/call1.svg" alt="">(+225) 07 00 122 662</a></li>
                        <li><a href="mailto:contact@gfi-co.net"><img src="assets/img/icons/mail1.svg" alt="">contact@gfi-co.net</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="blog-contact-boxarea">
                    <h3>Planifier un rendez-vous</h3>
                    <div class="space4"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-area">
                                <input type="text" placeholder="Prénom">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-area">
                                <input type="text" placeholder="Nom de famille">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="input-area">
                                <input type="email" placeholder="Votre E-mail">
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="input-area">
                                <input type="number" placeholder="Numéro de téléphone">
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="input-area">
                                <input type="text" placeholder="Votre message">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-area">
                                <textarea placeholder="Message"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="input-area">
                                <button type="submit" class="header-btn1">Envoyer <img src="assets/img/icons/arrow1.svg" alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== CONTACT AREA ENDS =======-->

@endsection
