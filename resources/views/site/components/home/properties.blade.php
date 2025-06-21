<!--===== PROPERTIES AREA STARTS =======-->
<div class="properties1-section-area sp1">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 m-auto">
        <div class="property-header text-center heading2">
          <h5 class="text-anim"><img src="assets/img/icons/logo-icon1.svg" alt="">Propriétés</h5>
          <h2 class="text-anim">Nos Propriétés</h2>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 m-auto">
        <div class="property-slider-area owl-carousel">
          @foreach($houses as $property)
          <div class="property-boxarea">
            <div class="img1 image-anime reveal">
                <img src="{{ $property->images->first() ? asset('storage/' . $property->images->first()->path) : 'https://loremflickr.com/800/600/house,exterior?lock='.$property->id }}" alt="{{ $property->title }}">
            </div>

            <div class="content-area">
              <h2>{{ number_format($property->price, 0, ',', ' ') }} FCFA</h2>
              <ul>
                <li><a href="#"><img src="assets/img/icons/sqft.svg" alt="">{{ $property->surface }} m²</a></li>
                @if($property->rooms)
                <li><a href="#"><img src="assets/img/icons/bed.svg" alt="">{{ $property->rooms }} Pièces</a></li>
                @endif
                @if($property->bathrooms)
                <li class="m-0"><a href="#"><img src="assets/img/icons/bath.svg" alt="">{{ $property->bathrooms }} SDB</a></li>
                @endif
              </ul>
              <p>{{ $property->address }}, {{ $property->city }}</p>
              <div class="space16"></div>
              <p>{{ $property->type === 'sale' ? 'À vendre' : 'À louer' }}</p>
              <div class="btn-area1">
                <a href="{{ route('properties.show', $property->id) }}" class="header-btn1">{{ $property->type === 'sale' ? 'Acheter' : 'Louer' }} <img src="assets/img/icons/arrow3.svg" alt=""></a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<!--===== PROPERTIES AREA ENDS =======-->