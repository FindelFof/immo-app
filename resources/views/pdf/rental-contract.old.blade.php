<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contrat de location</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
        }
        .container {
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border: 1px solid #ddd;
            width: 90%;
        }
        .logo {
            width: 100px;
            margin-bottom: 10px;
        }
        .section {
            margin-top: 20px;
            text-align: left;
        }
        .section h3 {
            color: #555;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    @if(file_exists(public_path('logo.png')))
        <img src="{{ public_path('logo.png') }}" class="logo" alt="{{$appName}}">
    @endif
    <h2>{{ $appName }}</h2>
    <h3>Contrat de location</h3>

    <div class="section">
        <h3>Informations du propriétaire</h3>
        <p>Nom : {{ $contract->property->owner->name }}</p>
        <p>Téléphone : {{ $contract->property->owner->phone }}</p>
    </div>

    <div class="section">
        <h3>Informations du locataire</h3>
        <p>Nom : {{ $contract->tenant->name }}</p>
        <p>Téléphone : {{ $contract->tenant->phone }}</p>
    </div>

    <div class="section">
        <h3>Détails du bien</h3>
        <p>Adresse : {{ $contract->property->address }}</p>
        <p>Prix mensuel : {{ number_format($contract->monthly_rent, 0, ',', ' ') }} FCFA</p>
        <p>Date de début : {{ $contract->start_date }}</p>
        <p>Date de fin : {{ $contract->end_date }}</p>
    </div>

    @if(!empty($contract->other_fees))
        <div class="section">
            <h3>Autres frais</h3>
            <p>{{ $contract->other_fees }}</p>
        </div>
    @endif

    <div class="footer">
        WhatsApp : {{ $whatsapp }} | Email : {{ $email }}<br>
        {{ $appName }} &copy; {{ now()->year }}
    </div>
</div>
</body>
</html>
