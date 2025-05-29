<!-- resources/views/pdfs/rent-receipt.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quittance De Loyer</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.3;
            color: #000;
            font-size: 11pt;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            color: #00205B;
            text-decoration: underline;
            margin: 0 0 5px 0;
        }
        .box {
            border: 1px solid #000;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
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
            margin-bottom: 5px;
            text-decoration: underline;
        }
        .field {
            margin-bottom: 4px;
        }
        .field-label {
            font-weight: bold;
        }
        .address-box {
            text-align: center;
            margin: 10px 0;
        }
        .address-title {
            font-weight: bold;
            text-decoration: underline;
            font-size: 12pt;
            color: #00205B;
            margin-bottom: 5px;
        }
        .address-line {
            border-bottom: 1px dotted #000;
            margin-bottom: 5px;
            padding-bottom: 2px;
        }
        .declaration {
            margin: 10px 0;
            text-align: justify;
            line-height: 1.3;
        }
        .details-box {
            border: 1px solid #000;
            border-radius: 8px;
            padding: 10px;
            margin: 10px 0;
        }
        .details-title {
            font-weight: bold;
            text-decoration: underline;
            color: #00205B;
            margin-bottom: 8px;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .amount {
            text-align: right;
            font-weight: bold;
        }
        .total {
            font-weight: bold;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #000;
        }
        .signature {
            margin-top: 15px;
            float: right;
            width: 50%;
        }
        .signature-title {
            font-weight: bold;
            text-decoration: underline;
        }
        .footer {
            clear: both;
            margin-top: 20px;
            text-align: center;
            font-size: 8pt;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
        .city-date {
            float: left;
            width: 45%;
            margin-top: 15px;
        }
        .details-box {
            border: 1px solid #000;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }

        .details-title {
            font-weight: bold;
            text-decoration: underline;
            color: #00205B;
            margin-bottom: 15px;
            font-size: 12pt;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            line-height: 1.3;
        }

        .payment-table th, .payment-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .payment-table th {
            background-color: #f5f5f5;
            text-align: left;
            font-weight: bold;
        }

        .payment-table .amount-column {
            text-align: right;
            width: 35%;
        }

        .payment-table .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
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
                <span class="field-label">Nom :</span> {{ $payment->rentalContract->property->owner->name }}
            </div>
            <div class="field">
                <span class="field-label">Email :</span> {{ $payment->rentalContract->property->owner->email ?? '' }}
            </div>
            <div class="field">
                <span class="field-label">Tél :</span> {{ $payment->rentalContract->property->owner->phone ?? '' }}
            </div>
        </div>

        <div class="column">
            <div class="title">Locataire :</div>
            <div class="field">
                <span class="field-label">Nom :</span> {{ $payment->rentalContract->tenant->name }}
            </div>
            <div class="field">
                <span class="field-label">Email :</span> {{ $payment->rentalContract->tenant->email ?? '' }}
            </div>
            <div class="field">
                <span class="field-label">Tél :</span> {{ $payment->rentalContract->tenant->phone ?? '' }}
            </div>
        </div>
    </div>
</div>

<div class="address-box">
    <div class="address-title">ADRESSE DE LA LOCATION :</div>
    <div class="address-line">{{ $payment->rentalContract->property->address }}</div>
    <div class="address-line">
        Ville : {{ $payment->rentalContract->property->city }}
    </div>
</div>

<div class="declaration">
    Je soussigné(e) {{ $payment->rentalContract->property->owner->name }}, propriétaire du
    logement désigné ci-dessus, atteste avoir reçu de {{ $payment->rentalContract->tenant->name }},
    la somme de {{ number_format($payment->amount, 0, ',', ' ') }} F CFA, à titre du règlement du loyer et des charges pour la période de
    location du {{ $payment->due_date->format('d/m/Y') }} au {{ $payment->due_date->copy()->endOfMonth()->format('d/m/Y') }}. Je lui délivre la présente quittance, sous réserve de mes
    droits.
</div>

<div class="details-box">
    <div class="details-title">DÉTAIL DU RÈGLEMENT :</div>

    <table class="payment-table">
        <tr>
            <th>Description</th>
            <th>Montant</th>
        </tr>
        <tr>
            <td>Loyer pour le mois de {{ $payment->due_date->format('F Y') }}</td>
            <td class="amount-column">{{ number_format($payment->amount, 0, ',', ' ') }} F CFA</td>
        </tr>
        <tr class="total-row">
            <td>Total</td>
            <td class="amount-column">{{ number_format($payment->amount, 0, ',', ' ') }} F CFA</td>
        </tr>
    </table>

    <!-- Information de paiement supplémentaire non visible dans le tableau -->
    <div style="display: none;">
        <div class="field">
            <span class="field-label">Date du paiement :</span> {{ $payment->payment_date->format('d/m/Y') }}
        </div>
        <div class="field">
            <span class="field-label">Pour la période :</span> {{ $payment->due_date->format('F Y') }}
        </div>
    </div>
</div>

<div class="city-date">
    Fait à : {{ $payment->rentalContract->property->city }} le {{ $payment->payment_date->format('d/m/Y') }}
</div>

<div class="signature">
    <div class="signature-title">Signature :</div>
</div>

</body>
</html>
