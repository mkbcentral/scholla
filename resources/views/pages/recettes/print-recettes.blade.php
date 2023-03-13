PA<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Impression liste des prduits</title>
    <style>
        .center {
            text-align: center;
        }
        table, td, th {
            border: 1px solid black;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div style="border: 1px solid black;padding: 6px">
        <div style="text-align: center;padding: 15px;font-size: 22px">
            <span>RECETTES MENSUELLES</span>
        </div>
        <div>
            <span style="font-weight: bold">Du mois de: {{strftime('%B', mktime(0, 0, 0, $month))}}</span>
            <div> <span>Année scolaire: {{$scolarYear->name}}</span></div>
        </div>

    </div>
    <div style="margin-top: 0px">
        @php
            $total=0;
            $total_etat=0;
        @endphp
        <table>
            <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                <tr>
                    <th style="text-align: center">N°</th>
                    <th style="text-align: left">Désignation</th>
                    <th style="text-align: right">MONTANT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($costs as $index => $cost)
                    @if ($cost->getTotal($month,$cost->id,$scolaryId)>0)
                    <tr>
                        <td style="text-align: center;width: 40px">{{$index+1}}</td>
                        <td style="text-align: left;text-transform: uppercase">
                            {{$cost->name}}
                        </td>
                        <td style="text-align: right">{{number_format($cost->getTotal($month,$cost->id,$scolaryId)*2000,1,',',' ')}}</td>
                    </tr>
                    @endif

                    @php
                        $total+=$cost->getTotal($month,$cost->id,$scolaryId)*2000;
                        if ($cost->id==6) {
                            $total_etat+=$cost->getTotal($month,$cost->id,$scolaryId)*2000;
                        }
                    @endphp
                @endforeach
                @if ($inscription>0)
                <tr>

                    <td style="text-align: center;width: 40px">7</td>
                    <td style="text-align: left">
                        INSCRIPTION
                    </td>
                    <td style="text-align: right">{{number_format($inscription*2000,1,',',' ')}}</td>
                </tr>
                @endif

                <tr>
                    <td style="text-align: center;width: 40px">7</td>
                    <td style="text-align: left">
                        PAIE
                    </td>
                    <td style="text-align: right">{{number_format($amount_salire*2000,1,',',' ')}}</td>
                </tr>
            </tbody>
        </table>
        <div style="text-align: right;font-size: 20px;margin-top: 10px;">
           <div style=" border: 1px solid rgb(112, 104, 104)">
                <div style="background: rgb(132, 131, 131);color: white">
                    <span style="font-weight: bold">Total: </span><span>{{ number_format($total+$inscription*2000,1,',',' ') }} Fc</span>
                </div>
                <div style="background: rgb(126, 115, 115);color: white">
                    <span style="font-weight: bold">Compte état: </span><span>{{ number_format($total_etat,1,',',' ') }} Fc</span>
                </div>
                <div style="background: rgb(126, 115, 115);color: white">
                    <span style="font-weight: bold">Paie: </span><span>{{ number_format($amount_salire,1,',',' ') }} Fc</span>
                </div>
                <div style="background: rgb(66, 66, 66);color: white">
                    <span style="font-weight: bold;">Solde école: </span><span>{{ number_format(($total+$inscription*2000-$total_etat)-$amount_salire,1,',',' ') }} Fc</span>
                </div>
           </div>
            <div style="margin-top: 8px">
                <span style="">Fiat à Lubumbashi,Le {{date('d/m/Y')}}</span>
            </div>
        </div>
        <div style="font-size: 18px;margin-top: 20px; padding: 8px;color: rgb(32, 32, 32)">
            <span style="font-weight: bold;margin-right: 400px">COMPTABLE</span>
            <span style="font-weight: bold">COORDONATEUR</span>
        </div>
    </div>
</body>
</html>
