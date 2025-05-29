<header>
    <div class="header-area homepage1 header header-sticky d-none d-lg-block" id="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-elements">
                        <div class="site-logo">
                            <a href="/"><img src="assets/img/logo/logo1.png" alt="Logo du site"></a>
                        </div>
                        <div class="main-menu">
                            <ul>
                                <li><a href="#">Accueil <i class="fa-solid fa-angle-down"></i></a>
                                    <div class="tp-submenu">
                                        <!-- Contenu du sous-menu -->
                                    </div>
                                </li>
                                <li><a href="/a-propos">À propos</a></li>
                                <li><a href="#">Propriétés <i class="fa-solid fa-angle-down"></i></a>
                                    <ul class="dropdown-padding">
                                        <li><a href="/proprietes">Toutes les propriétés</a></li>
                                        <li><a href="/proprietes/localisation">Localisation</a></li>
                                        <li><a href="/proprietes/vente-location">Vente & Location</a></li>
                                        <li><a href="/proprietes/liste">Liste des propriétés</a></li>
                                        <li><a href="/proprietes/liste-gauche">Liste gauche</a></li>
                                        <li><a href="/proprietes/liste-droite">Liste droite</a></li>
                                        <li><a href="/proprietes/details">Détail propriété</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Blogs <i class="fa-solid fa-angle-down"></i></a>
                                    <ul class="dropdown-padding">
                                        <!-- Sous-menu blogs -->
                                    </ul>
                                </li>
                                <li><a href="#">Pages <i class="fa-solid fa-angle-down"></i></a>
                                    <ul class="dropdown-padding">
                                        <!-- Sous-menu pages -->
                                    </ul>
                                </li>
                                <li><a href="/contact">Contact</a></li>
                            </ul>
                        </div>
                        <div class="btn-area">
                            <div class="search-icon header__search header-search-btn">
                                <a href="#"><img src="assets/img/icons/search1.svg" alt="Rechercher"></a>
                            </div>
                            <a href="/proprietes" class="header-btn1">Voir nos propriétés <img src="assets/img/icons/arrow1.svg" alt=""></a>
                        </div>

                        <div class="header-search-form-wrapper">
                            <!-- Formulaire de recherche -->
                        </div>
                        <div class="body-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Header Mobile -->
@include('layouts.partials.mobile-header')
