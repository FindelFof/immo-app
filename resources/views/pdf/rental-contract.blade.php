<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contrat de Location {{ $contract->contract_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #000;
            font-size: 10pt;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h1 {
            font-size: 13pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            font-size: 10pt;
            margin: 5px 0;
        }
        .box {
            border: 1px solid #000;
            margin-bottom: 14px;
            padding: 10px;
        }
        .box-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .underscore {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 150px;
        }
        .indent {
            margin-left: 20px;
        }
        .parties, .property, .terms, .signatures {
            margin-bottom: 15px;
        }
        .half {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
        .full-width {
            width: 100%;
        }
        .bold {
            font-weight: bold;
        }
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        .signature-line {
            margin-top: 15px;
            border-top: 1px dotted #000;
            width: 45%;
            display: inline-block;
            text-align: center;
            margin-right: 15px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Contrat de Location</h1>
    <p>N° {{ $contract->contract_number }} établi le {{ $contract->contract_date->format('d/m/Y') }}</p>
</div>

<div class="box">
    <div class="box-title">Entre les soussignés</div>

    <div>
        M./Mme/Mlle <span class="underscore">{{ $contract->property->owner->name }}</span><br>
        demeurant <span class="underscore">{{ $contract->property->owner->address ?? '________________________________' }}</span><br>
        <div class="bold" style="margin-top: 5px; margin-bottom: 5px; text-align: right;">LE BAILLEUR d'une part,</div>

        ET M./Mme/Mlle <span class="underscore">{{ $contract->tenant->name }}</span><br>
        demeurant <span class="underscore">{{ $contract->tenant->address ?? '________________________________' }}</span><br>
        <div class="bold" style="margin-top: 5px; text-align: right;">LE LOCATAIRE d'autre part.</div>
    </div>
</div>

<div style="font-weight: bold; text-decoration: underline; margin-bottom: 10px; text-align: center;">
    Il a été arrêté et convenu ce qui suit : le bailleur loue les locaux et équipements, ci-après désignés, au locataire qui les accepte aux conditions suivantes.
</div>

<div class="box">
    <div class="box-title">Désignation</div>

    <div>
        Adresse des locaux loués : <span class="underscore">{{ $contract->property->address }}, {{ $contract->property->city }}</span><br>
        Bâtiment : ____________ étage : ____________ porte : ____________ superficie : {{ $contract->property->surface ?? '________' }} m²<br>

        <div style="margin-top: 8px;">Consistance et désignation des lieux :</div>
        <div style="margin-top: 5px;">
            <span class="checkbox">@if($contract->property->property_type == 'apartment') ✓ @endif</span> Appartement
            <span class="checkbox" style="margin-left: 20px;">@if($contract->property->property_type == 'house') ✓ @endif</span> Maison individuelle
        </div>

        <div style="margin-top: 8px;">
            @if($contract->property->rooms) Nombre de pièces : {{ $contract->property->rooms }} @endif
            @if($contract->property->bathrooms) - Nombre de salles de bain : {{ $contract->property->bathrooms }} @endif
        </div>
    </div>
</div>

<div class="box">
    <div class="box-title">Destination</div>

    <div>
        <span class="checkbox">✓</span> HABITATION EXCLUSIVEMENT<br>
        <span class="checkbox"></span> HABITATION ET EXERCICE de la profession de ____________
    </div>
</div>

<div class="box">
    <div class="box-title">Durée</div>

    <div>
        Le présent contrat est consenti pour une durée de {{ $contract->start_date->diffInMonths($contract->end_date) }} mois commençant à courir le {{ $contract->start_date->format('d/m/Y') }} et se terminant le {{ $contract->end_date->format('d/m/Y') }}.
    </div>
</div>

<div class="box">
    <div class="box-title">Loyer et charges</div>

    <div>
        <div>LOYER MENSUEL : <span class="bold">{{ number_format($contract->monthly_rent, 0, ',', ' ') }} F CFA</span></div>
        <div>CAUTION : <span class="bold">{{ number_format($contract->deposit, 0, ',', ' ') }} F CFA</span></div>

        @if(!empty($contract->others_fees))
            <div style="margin-top: 8px;">FRAIS SUPPLÉMENTAIRES :</div>
            <table style="margin-top: 5px;">
                <tr>
                    <th>Description</th>
                    <th>Montant</th>
                    <th>Fréquence</th>
                </tr>
                @foreach($contract->others_fees as $fee)
                    <tr>
                        <td>{{ $fee['name'] }}</td>
                        <td>{{ number_format($fee['amount'], 0, ',', ' ') }} F CFA</td>
                        <td>
                            @switch($fee['frequency'])
                                @case('monthly') Mensuel @break
                                @case('quarterly') Trimestriel @break
                                @case('yearly') Annuel @break
                                @case('one_time') Unique @break
                                @default {{ $fee['frequency'] }}
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>

<div style="margin-top: 20px;">
    <div>Fait à __________________, le __________________</div>

    <div style="margin-top: 15px;">
        <div class="signature-line">
            Le Bailleur<br>
            (signature précédée de la mention "Lu et approuvé")
        </div>

        <div class="signature-line">
            Le Locataire<br>
            (signature précédée de la mention "Lu et approuvé")
        </div>
    </div>
</div>
</body>
</html>
