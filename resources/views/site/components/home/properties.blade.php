<!--===== PROPERTIES AREA STARTS =======-->
<div class="properties1-section-area sp1">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 m-auto">
        <div class="property-header text-center heading2">
          <h5 class="text-anim" style="color: var(--secondary-color);">Nos Biens</h5>
          <h2 class="text-anim">Découvrez Nos Propriétés</h2>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 m-auto">
        <div class="property-slider-area owl-carousel">
          
          @foreach($houses as $property)
          <!-- Card de Propriété Unique -->
          <div class="property-boxarea" style="position: relative; border-radius: 15px; overflow: hidden; height: 550px;">
            
            <!-- Image en fond -->
            <img src="{{ $property->images->first() ? asset('storage/' . $property->images->first()->path) : 'https://loremflickr.com/800/600/modern,house,interior?lock='.$property->id }}" alt="{{ $property->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            
            <!-- Carte d'information avec fond en dégradé -->
            <div class="content-area" style="position: absolute; bottom: 0; left: 30px; right: 0; background: linear-gradient(transparent, var(--primary-color)); color: var(--text-light); padding: 80px 35px 35px 35px; z-index: 2;">
              
              <h2 style="color: var(--text-light) !important; font-size: 1.8rem;">{{ number_format($property->price, 0, ',', ' ') }} FCFA</h2>
              <div style="height: 10px;"></div>

              <h4 style="color: var(--text-light) !important; font-size: 1.1rem; font-weight: 600;">{{ $property->title }}</h4>
              <p style="color: var(--text-light) !important; opacity: 0.8; font-size: 0.9rem;">{{ Str::limit($property->description, 70) }}</p>

              <hr style="border-color: rgba(255, 255, 255, 0.2);">

              <div style="display: flex; justify-content: space-between; align-items: center; color: var(--text-light);">
                <ul style="display: flex; gap: 30px; list-style: none; padding: 0; margin: 0; font-size: 0.9rem;">
                  @if($property->surface)
                  <li><i class="fa-solid fa-ruler-combined" style="margin-right: 5px;"></i>{{ $property->surface }} m²</li>
                  @endif
                  @if($property->rooms)
                  <li><i class="fa-solid fa-bed" style="margin-right: 5px;"></i>{{ $property->rooms }} Pièces</li>
                  @endif
                  @if($property->bathrooms)
                  <li><i class="fa-solid fa-bath" style="margin-right: 5px;"></i>{{ $property->bathrooms }} SDB</li>
                  @endif
                </ul>
                <a href="{{ route('properties.show', $property->id) }}" class="header-btn1" style="background: var(--secondary-color) !important; border-color: var(--secondary-color) !important; padding: 8px 15px; font-size: 0.9rem;">
                  {{ $property->type === 'sale' ? 'Acheter' : 'Louer' }}
                </a>
              </div>
            </div>

          </div>
          <!-- Fin de la Card -->
          @endforeach

        </div>
      </div>
    </div>
  </div>
</div>
<!--===== PROPERTIES AREA ENDS =======-->