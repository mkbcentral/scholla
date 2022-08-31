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
            font-size: 14px;
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
            <span>SITUATION DE PAIMENT DES FRAIS PERIODIQUE </span>
        </div>
        <div>
            <span style="margin-top: 8px;margin-bottom: 8px ">
                Période: {{$label}}
            </span>
        </div>
        <div>
            <span>Motifs: {{$motif}}</span>
        </div>
        <div>
            <span>Année scolaire: {{$defaultScolaryYer->name}}</span>
        </div>
    </div>
    </div>

    @php
        $total=0;;
    @endphp
    <div>
        @if ($paiments->isEmpty())

                    @else
                    <table sty>
                        <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                            <tr>
                                <th>N°</th>
                                <th>DATE</th>
                                <th>CODE</th>
                                <th>ELEVE</th>
                                <th>TYPE</th>
                                <th style="text-align: right">MONTANT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paiments as $index=> $paiment)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$paiment->created_at->format('d/m/Y')}}</td>
                                    <td>{{$paiment->number_paiement}}</td>
                                    <td>{{$paiment->student->name.'/'.$paiment->student->classe->name.'/'.$paiment->student->classe->option->name}}</td>
                                    <td>{{$paiment->cost->name.'/'.strftime('%B', mktime(0, 0, 0, $paiment->mounth_name)) }}</td>
                                    <td style="text-align: right">{{number_format($paiment->cost->amount*$taux,1,',',' ') }}</td>
                                </tr>
                                @php
                                    $total+=$paiment->cost->amount;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    @endif
        <div style="text-align: right;font-size: 18px;margin-top: 10px;">
<span style="font-weight: bold">Total: </span><span>{{ number_format($total,1,',',' ') }} Fc</span>
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
