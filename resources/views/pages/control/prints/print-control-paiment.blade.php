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
            <span>LISTING DES ELEVES QUI NE SONT PAS EN ORDRE</span>
        </div>
        <div>
            <span style="font-weight: bold">Mois:</span>
            <span>{{strftime('%B', mktime(0, 0, 0, $month))}}</span>
        </div>
        <div>
            <span style="font-weight: bold">Classe: </span>
            <span>{{$classe->name.'/'.$classe->option->name}}</span>
        </div>
        <div>
            <span style="font-weight: bold">Année scolaire: </span>
            <span>{{$scolaryYear->name}}</span>
        </div>
        <div>
            <span style="font-weight: bold">Type: </span>
            <span>{{$cost->name}}</span>
        </div>
        <div>
            <span style="font-weight: bold">Total: </span>
            <span>{{$inscriptions->count()}}</span>
        </div>

    </div>
    <div style="margin-top: 0px">
        @if ($inscriptions->isEmpty())

        @else
            <table>
                <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th style="text-align: left">NOM COMPLE</th>
                        <th style="text-align: right">TYPE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inscriptions as $index => $inscription)
                            <tr>
                                <td style="text-align: center;width: 40px">{{$index+1}}</td>
                                <td style="">{{$inscription->student->name}}</td>
                                <td style="text-align: right">{{$cost->name}}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
