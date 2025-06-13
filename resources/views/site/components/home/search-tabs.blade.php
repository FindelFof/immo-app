<div class="tabs-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="tabs-area">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Louer</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Acheter</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Vendre</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Onglet Rent -->
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                            <form action="{{ route('properties.search') }}" method="GET">
                                <input type="hidden" name="type" value="rent">
                                <div class="all-cities-area">
                                    <div class="cities">
                                        <p>Ville/Quartier</p>
                                        <div class="input-place after">
                                            <select name="city" class="nice-select">
                                                <option value="" data-display="Abidjan">Abidjan</option>
                                                @foreach($cities ?? [] as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Autres champs -->
                                    <div class="cities">
                                        <div class="input-place">
                                            <button type="submit" class="header-btn1">Rechercher <img src="{{ asset('assets/img/icons/search1.svg') }}" alt=""></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Autres onglets Buy et Sell -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
