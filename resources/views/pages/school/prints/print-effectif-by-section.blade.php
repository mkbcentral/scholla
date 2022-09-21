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
            <span>LISTING EFFECTIF PAR CLASSES</span>
        </div>
        <div>
            <div><span><span style="font-weight: bold">Année scolaire:</span style="font-weight: bold"> {{$defaultScolaryYer->name}}</span></div>
        </div>
    </div>
    <div style="margin-top: 0px">
        @if ($classes->isEmpty())

        @else
            <table>
                <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th style="text-align: left">CLASSE</th>
                        <th style="text-align: center">NOMBRE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classes as $index => $classe)
                            <tr>
                                <td style="text-align: center;width: 40px">{{$index+1}}</td>
                                <td style="">{{$classe->name.'/'.$classe->option->name}}</td>
                                <td style="text-align: center">{{$classe->students->count()}}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
