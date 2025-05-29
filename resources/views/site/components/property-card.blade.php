@props(['property'])

<div class="featured-boxarea">
    <div class="img1">
        <img src="{{ $property->featured_image_url }}" alt="{{ $property->title }}">
    </div>
    <div class="sell-point">
        <a href="{{ route('properties.show', $property->slug) }}" class="sell">{{ $property->status }}</a>
        @if($property->is_featured)
            <a href="{{ route('properties.show', $property->slug) }}" class="featured">Featured</a>
        @endif
    </div>
    <div class="content-area">
        <a href="{{ route('properties.show', $property->slug) }}">{{ $property->title }}</a>
        <p>{{ $property->address }}</p>
        <ul>
            <li><a href="#"><img src="{{ asset('assets/img/icons/sqft.svg') }}" alt="">{{ $property->area }} sqft</a></li>
            <li><a href="#"><img src="{{ asset('assets/img/icons/bed.svg') }}" alt="">{{ $property->bedrooms }} Beds</a></li>
            <li class="m-0"><a href="#"><img src="{{ asset('assets/img/icons/bath.svg') }}" alt="">{{ $property->bathrooms }} Baths</a></li>
        </ul>
        <div class="price-area">
            <h3>
                ${{ number_format($property->price) }}
                @if($property->status === 'Rent')
                    <span>/ Mois</span>
                @endif
            </h3>
            <a href="#" class="favorite-toggle" data-property-id="{{ $property->id }}">
                <img src="{{ asset('assets/img/icons/like.svg') }}" alt="" class="like1">
                <img src="{{ asset('assets/img/icons/like1.svg') }}" alt="" class="like2">
            </a>
        </div>
    </div>
</div>
