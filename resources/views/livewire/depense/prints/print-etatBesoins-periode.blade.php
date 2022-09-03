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
            <span>SITUATION ETAT DES BESOINS PERIODIQUE</span>
        </div>
        <span style="margin-top: 8px;margin-bottom: 8px ">Pour le : {{$label}}</span>
    </div>
    </div>

    @php
        $total=0;;
    @endphp
    <div>
        @if ($etatBesoins->isEmpty())

                    @else
                    <table sty>
                        <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                            <tr>
                                <th style="text-align: left">DATE</th>
                                <th style="text-align: left">MOTIF</th>
                                <th style="text-align: right;">MONTANT</th>
                                <th style="text-align: right;">OBSERVATION</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($etatBesoins as $etatBesoin)
                                <tr>
                                    <td>{{$etatBesoin->created_at->format('d/m/Y')}}</td>
                                    <td style="">{{$etatBesoin->title}}</td>
                                    <td style="text-align: right">{{number_format($etatBesoin->amount,1,',',' ')}}</td>
                                    <td style="text-align: right">{{$etatBesoin->description}}</td>
                                </tr>
                                @php
                                    $total+=$etatBesoin->amount;
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
