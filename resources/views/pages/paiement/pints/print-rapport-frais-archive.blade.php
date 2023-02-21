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
            <span style="text-transform: uppercase">ARCHIVE DES PAIMENTS ARCHIVES POUR LE MOIS DE JUIN</span>
        </div>
        <div>
            <span>Classe: {{$classe->name.'/'.$classe->option->name}}</span>
        </div>
        <div>
            Du mois de: {{strftime('%B', mktime(0, 0, 0, $month,10))}}
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
        <table sty>
            <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                <tr>
                    <th style="text-align: center">N°</th>
                    <th style="text-align: left">DATE</th>
                    <th style="text-align: left">NOMS ELEVE</th>
                    <th style="text-align: right">MONTANT</th>
                </tr>
                </tr>
            </thead>
            <tbody>
                @foreach ($paiments as $index=> $paiment)
                    <tr>
                        <td style="text-align: center">{{$index+1}}</td>
                        <td style="text-align: left">{{$paiment->created_at->format('d/m/Y')}}</td>
                        <td>{{$paiment->student->name}}</td>
                        <td style="text-align: right">
                            {{number_format($paiment->getArchiveAmoun($costId),1,',',' ') }}
                        </td>
                    </tr>
                    @php
                        $total+=$paiment->getArchiveAmoun($costId);
                    @endphp
                @endforeach
            </tbody>
        </table>
        <div style="text-align: right;font-size: 18px;margin-top: 10px;">
<span style="font-weight: bold">Total: </span><span>{{ number_format($total,1,',',' ') }} Fc</span>
<div style="margin-top: 8px">
    <span style="">Fiat à Lubumbashi,Le {{date('d/m/Y')}}</span>
</div>
</div>
    </div>
    <div style="font-size: 18px;margin-top: 20px; padding: 8px;color: rgb(32, 32, 32)">
        <span style="font-weight: bold;margin-right: 550">COMPTABLE</span>
        <span style="font-weight: bold">COORDONATEUR</span>
    </div>
</body>
</html>
