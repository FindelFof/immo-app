<!-- resources/views/pdfs/rent-receipt.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quittance De Loyer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #000;
            font-size: 12pt;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            color: #00205B;
            text-decoration: underline;
        }
        .box {
            border: 1px solid #000;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .column {
            width: 48%;
        }
        .title {
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        .field {
            margin-bottom: 8px;
        }
        .field-label {
            font-weight: bold;
        }
        .address-box {
            text-align: center;
            margin: 20px 0;
        }
        .address-title {
            font-weight: bold;
            text-decoration: underline;
            font-size: 14pt;
            color: #00205B;
            margin-bottom: 10px;
        }
        .address-line {
            border-bottom: 1px dotted #000;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }
        .declaration {
            margin: 20px 0;
            text-align: justify;
            line-height: 2;
        }
        .details-box {
            border: 1px solid #000;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
        }
        .details-title {
            font-weight: bold;
            text-decoration: underline;
            color: #00205B;
            margin-bottom: 15px;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .amount {
            text-align: right;
            font-weight: bold;
        }
        .total {
            font-weight: bold;
            margin-top: 10px;
        }
        .signature {
            margin-top: 40px;
        }
        .signature-title {
            font-weight: bold;
            text-decoration: underline;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10pt;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .footer-logo {
            margin-top: 10px;
            text-align: right;
            font-size: 24pt;
            font-weight: bold;
            color: #00A651;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Quittance De Loyer</h1>
</div>

<div class="box">
    <div>Quittance de loyer pour la période du {{ $payment->due_date->format('d/m/Y') }} au {{ $payment->due_date->copy()->endOfMonth()->format('d/m/Y') }}</div>
</div>

<div class="box">
    <div class="row">
        <div class="column">
            <div class="title">Propriétaire :</div>
            <div class="field">
                <span class="field-label">Prénom et Nom :</span> {{ $payment->rentalContract->property->owner->name }}
            </div>
            <div class="field">
                <span class="field-label">Adresse :</span> {{ $payment->rentalContract->property->owner->address ?? '' }}
            </div>
            <div class="field">
                <span class="field-label">Code postal et Ville :</span> {{ $payment->rentalContract->property->owner->postal_code ?? '' }} {{ $payment->rentalContract->property->city ?? '' }}
            </div>
            <div class="field">
                <span class="field-label">Email :</span> {{ $payment->rentalContract->property->owner->email ?? '' }}
            </div>
            <div class="field">
                <span class="field-label">Téléphone :</span> {{ $payment->rentalContract->property->owner->phone ?? '' }}
            </div>
        </div>

        <div class="column">
            <div class="title">Locataire :</div>
            <div class="field">
                <span class="field-label">Prénom et Nom :</span> {{ $payment->rentalContract->tenant->name }}
            </div>
            <div class="field">
                <span class="field-label">Adresse :</span> {{ $payment->rentalContract->tenant->address ?? '' }}
            </div>
            <div class="field">
                <span class="field-label">Code postal et Ville :</span> {{ $payment->rentalContract->tenant->postal_code ?? '' }} {{ $payment->rentalContract->property->city ?? '' }}
            </div>
            <div class="field">
                <span class="field-label">Email :</span> {{ $payment->rentalContract->tenant->email ?? '' }}
            </div>
            <div class="field">
                <span class="field-label">Téléphone :</span> {{ $payment->rentalContract->tenant->phone ?? '' }}
            </div>
        </div>
    </div>
</div>

<div class="address-box">
    <div class="address-title">ADRESSE DE LA LOCATION :</div>
    <div class="address-line">{{ $payment->rentalContract->property->address }}</div>
    <div class="address-line">
        Code postal : {{ $payment->rentalContract->property->postal_code ?? '' }}
    </div>
    <div class="address-line">
        Ville : {{ $payment->rentalContract->property->city }}
    </div>
</div>

<div class="declaration">
    Je soussigné(e) {{ $payment->rentalContract->property->owner->name }}, propriétaire / bailleur du
    logement désigné ci-dessus, atteste avoir reçu de Monsieur / Madame {{ $payment->rentalContract->tenant->name }},
    la somme de {{ number_format($payment->amount, 0, ',', ' ') }} F CFA (en toutes lettres),
    soit {{ number_format($payment->amount, 0, ',', ' ') }} F CFA (en chiffres), à titre du règlement du loyer et des charges pour la période de
    location du {{ $payment->due_date->format('d/m/Y') }} au {{ $payment->due_date->copy()->endOfMonth()->format('d/m/Y') }}. Je lui délivre la présente quittance, sous réserve de mes
    droits.
</div>

<div class="details-box">
    <div class="details-title">DÉTAIL DU RÈGLEMENT :</div>

    <div class="field">
        <span class="field-label">Date du paiement :</span> {{ $payment->payment_date->format('d/m/Y') }}
    </div>
    <div class="field">
        <span class="field-label">Pour la période :</span> {{ $payment->due_date->format('F Y') }}
    </div>

    <div class="details-row">
        <div class="field-label">Montant du loyer :</div>
        <div class="amount">{{ number_format($payment->amount, 0, ',', ' ') }} F CFA</div>
    </div>

    <div class="details-row">
        <div class="field-label">Montant des charges :</div>
        <div class="amount">0 F CFA</div>
    </div>

    <div class="details-row total">
        <div class="field-label">TOTAL PAYÉ</div>
        <div class="amount">{{ number_format($payment->amount, 0, ',', ' ') }} F CFA</div>
    </div>
</div>

<div>
    Fait à : {{ $payment->rentalContract->property->city }} le {{ $payment->payment_date->format('d/m/Y') }}
</div>

<div class="signature">
    <div class="signature-title">Signature :</div>
</div>

<div class="footer">
    Document propulsé par {{ config('app.name') }}
    <div class="footer-logo">
        {{ config('app.name') }}
    </div>
</div>
</body>
</html>
