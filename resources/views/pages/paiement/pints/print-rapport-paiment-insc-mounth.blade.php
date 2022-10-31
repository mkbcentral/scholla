<!DOCTYPE html>
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
            font-size: 18px;
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
            <span>SITUATION DE PAIMENT DES INSCRIPTIONS MENSUELLE</span>
        </div>
        <div>
            <span style="margin-top: 8px;margin-bottom: 8px "><span style="font-weight: bold">Mois de</span>: {{strftime('%B', mktime(0, 0, 0, $month,10))}}</span>
        </div>
        <div>
            <span style="margin-top: 8px;margin-bottom: 8px "><span style="font-weight: bold">Année scolaire</span>: {{$defaultScolaryYer->name}}</span>
        </div>
    </div>
    </div>

    @php
        $total=0;;
    @endphp
    <div>
        @if ($inscriptions->isEmpty())

                    @else
                    <table sty>
                        <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                            <tr>
                                <th style="text-align: center">N°</th>
                                <th style="text-align: left">DATE</th>
                                <th style="text-align: left">ELEVE</th>
                                <th style="text-align: right;">TYPE PAIEMENT</th>
                                <th style="text-align: right;">MONTANT</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($inscriptions as $index => $inscription)
                                <tr>
                                    <td style="text-align: center">{{$index+1}}</td>
                                    <td>{{$inscription->created_at->format('d/m/Y')}}</td>
                                    <td style="">{{$inscription->student->name.'/'.$inscription->student->firstname.' '.$inscription->student->lastname.' '.$inscription->student->classe->name.'-'.$inscription->student->classe->option->name}}</td>
                                    <td style="text-align: right">{{$inscription->cost->name}}</td>
                                    <td style="text-align: right">{{number_format($inscription->cost->amount*$taux,1,',',' ')}}</td>
                                </tr>
                                @php
                                    $total+=$inscription->cost->amount;
                                @endphp
                        @endforeach
                        </tbody>
                    </table>
                    @endif
        <div style="text-align: right;font-size: 30px;margin-top: 10px;">
<span style="font-weight: bold">Total: </span><span>{{ number_format($total*$taux,1,',',' ') }} Fc</span>
<div style="margin-top: 8px">
    <span style="">Fiat à Lubumbashi,Le {{date('d/m/Y')}}</span>
</div>
</div>
    </div>
    <div style="font-size: 18px;margin-top: 20px; padding: 8px;color: rgb(32, 32, 32)">
        <span style="font-weight: bold;margin-right: 400px">COMPTABLE</span>
        <span style="font-weight: bold">COORDONATEUR</span>
    </div>
</body>
</html>
