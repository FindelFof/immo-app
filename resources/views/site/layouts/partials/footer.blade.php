<style>
    .footer-v2-section {
        background-color: #fff;
        color: #555;
        padding: 80px 0 0;
        border-top: 1px solid #e9e9e9;
        font-family: 'Poppins', sans-serif;
    }
    .footer-v2-widget h5 {
        font-size: 16px;
        font-weight: 600;
        color: #222;
        margin-bottom: 25px;
    }
    .footer-v2-widget p {
        color: #555;
    }
    .footer-v2-widget ul {
        list-style: none;
        padding: 0;
    }
    .footer-v2-widget ul li a {
        color: #555;
        text-decoration: none;
        margin-bottom: 12px;
        display: inline-block;
        transition: color 0.3s;
    }
    .footer-v2-widget ul li a:hover {
        color: var(--primary-color);
    }
    .footer-v2-widget .contact-info li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    .footer-v2-widget .contact-info i {
        margin-right: 15px;
        margin-top: 5px;
        color: var(--primary-color);
    }
    .newsletter-form-v2 {
        position: relative;
        margin-bottom: 25px;
    }
    .newsletter-form-v2 input {
        width: 100%;
        padding: 15px 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }
    .newsletter-form-v2 button {
        background: var(--primary-color);
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        margin-top: 10px;
        cursor: pointer;
    }
    .social-icons-v2 a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid #e0e0e0;
        color: #222;
        text-decoration: none;
        margin-right: 10px;
        transition: background-color 0.3s, color 0.3s;
    }
    .social-icons-v2 a:hover {
        background-color: var(--primary-color);
        color: #fff;
    }
    .footer-v2-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        margin-top: 60px;
        border-top: 1px solid #e9e9e9;
        font-size: 14px;
    }
</style>

<div class="footer-v2-section">
  <div class="container">
    <div class="row">

      <!-- Colonne 1: Newsletter -->
      <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
        <div class="footer-v2-widget">
            <a href="/"><img src="{{ asset('assets/img/logo/logo-dark.png') }}" alt="Logo" style="max-width: 150px; margin-bottom: 20px;"></a>
            <h5>Abonnement à la newsletter</h5>
            <p>En conformité avec les normes environnementales, et les standards de référence en la matière, GFI-CO SARL est une entreprise immobilière dont la spécificité réside dans la construction et la promotion de maison écologique.</p>
            <form action="#" class="newsletter-form-v2 mt-3">
                <input type="email" placeholder="Entrez votre adresse e-mail" class="form-control mb-2">
                <button type="submit">S'inscrire <i class="fa-solid fa-arrow-right-long"></i></button>
            </form>
            <div class="social-icons-v2">
                <a href="https://www.facebook.com/gficosarl" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/gfi-co-sarl/" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="https://www.youtube.com/@gfi-co" target="_blank"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>
      </div>

      <!-- Colonne 2: Liens Rapides -->
      <div class="col-lg-2 col-md-6 mb-5 mb-lg-0">
        <div class="footer-v2-widget">
          <h5>Liens rapides</h5>
          <ul>
            <li><a href="#">Présentation</a></li>
            <li><a href="#">Demande de devis</a></li>
            <li><a href="#">Nos projets</a></li>
            <li><a href="#">Blog & Actus</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
      </div>

      <!-- Colonne 3: Nos Services -->
      <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
        <div class="footer-v2-widget">
          <h5>Nos Services</h5>
          <ul>
            <li><a href="#">Construction</a></li>
            <li><a href="#">Immobilier</a></li>
            <li><a href="#">Énergies renouvelables</a></li>
            <li><a href="#">Travaux publics</a></li>
            <li><a href="#">Gestion Immobilière</a></li>
          </ul>
        </div>
      </div>

      <!-- Colonne 4: Contact -->
      <div class="col-lg-3 col-md-6">
        <div class="footer-v2-widget">
          <h5>Contact</h5>
          <ul class="contact-info">
            <li>
              <i class="fa-solid fa-location-dot"></i>
              <span>LT 18 IL 1 AKOUEDO TRIANGLE, Quartier 09 Secteur Palmeraie, Abidjan, Côte d'Ivoire</span>
            </li>
            <li>
              <i class="fa-solid fa-phone"></i>
              <span>(+225) 07 00 122 662</span>
            </li>
            <li>
              <i class="fa-solid fa-envelope"></i>
              <span>contact@gfi-co.net</span>
            </li>
             <li>
                <i class="fa-solid fa-clock"></i>
                <span>Lundi – Vendredi : 08H – 17H</span>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
  <div class="footer-v2-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <p class="mb-0">&copy;Copyright {{ date('Y') }} GFI-CO. Tous droits réservés</p>
        <div>
            <a href="#" class="me-3 text-decoration-none" style="color: #555;">Conditions d'utilisation</a>
            <a href="#" class="text-decoration-none" style="color: #555;">Politique de confidentialité</a>
        </div>
    </div>
  </div>
</div>
