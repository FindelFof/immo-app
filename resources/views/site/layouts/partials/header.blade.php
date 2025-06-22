<header>
    <div class="header-area homepage1 header header-sticky d-none d-lg-block" id="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-elements">
                        <div class="site-logo">
                            <a href="/"><img src="assets/img/logo/logo-dark.png" alt="Logo du site"></a>
                        </div>
                        <div class="main-menu">
                            <ul>
                                <li>
                                    <a href="/">Accueil</a>
                                </li>
                                <li><a href="/location-vente">Location/Vente</a></li>
                                <li><a href="/achat-terrain">Achat de terrain</a></li>
                                <li><a href="/contact">Contact</a></li>
                            </ul>
                        </div>
                        <div class="btn-area">
                            <!-- <div class="search-icon header__search header-search-btn">
                                <a href="#"><img src="assets/img/icons/search1.svg" alt="Rechercher"></a>
                            </div> -->
                            <a href="/profil" class="header-btn1">Connexion / Inscription</a>
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
 <!--===== MOBILE HEADER STARTS =======-->
 <div class="mobile-header mobile-haeder1 d-block d-lg-none">
  <div class="container-fluid">
    <div class="col-12">
      <div class="mobile-header-elements">
        <div class="mobile-logo">
          <a href="/"><img src="assets/img/logo/logo-dark.png" alt=""></a>
        </div>
        <div class="mobile-nav-icon dots-menu">
          <i class="fa-solid fa-bars-staggered"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="mobile-sidebar mobile-sidebar1">
  <div class="logosicon-area">
    <div class="logos">
      <img src="assets/img/logo/logo-dark.png" alt="">
    </div>
    <div class="menu-close">
      <i class="fa-solid fa-xmark"></i>
    </div>
   </div>
  <div class="mobile-nav mobile-nav1">
    <ul class="mobile-nav-list nav-list1">
        <li><a href="/">Accueil</a></li>
        <li><a href="/location-vente">Location/Vente</a></li>
        <li><a href="/achat-terrain">Achat de terrain</a></li>
        <li><a href="/contact">Contact</a></li>
    </ul>
     </div>
</div>
<!--===== MOBILE HEADER STARTS =======-->
@include('site.layouts.partials.mobile-header')
