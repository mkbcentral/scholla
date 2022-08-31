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
            <span>LISTE DES ELEVES</span>
        </div>
        <div>
            <div><span><span style="font-weight: bold">Classe:</span> {{$classe->name.'/'.$classe->option->name}}</span></div>
            <div><span><span style="font-weight: bold">Année scolaire:</span style="font-weight: bold"> {{$defaultScolaryYer->name}}</span></div>
            <div><span><span style="font-weight: bold">Titulaire:</span style="font-weight: bold"> {{Auth::user()->name}}</span></div>
            <div><span><span style="font-weight: bold">Total:</span style="font-weight: bold"> {{$inscriptions->count()}} élèves</span></div>
        </div>
    </div>
    <div style="margin-top: 0px">
        @if ($inscriptions->isEmpty())

        @else
            <table>
                <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th style="text-align: left">NOM COMPLET DE L'ELEVE</th>
                        <th style="text-align: center">GENRE</th>
                        <th style="text-align: center">AGE</th>
                        <th style="text-align: right;">CLASSE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inscriptions as $index => $inscription)
                            <tr>
                                <td style="text-align: center">{{$index+1}}</td>
                                <td style="">{{$inscription->name}}</td>
                                <td style="text-align: center">{{$inscription->gender}}</td>
                                <td style="text-align: center">{{date('Y')-$inscription->student->date_of_birth->format('Y')==0?
                                        'Inconnu':date('Y')-$inscription->student->date_of_birth->format('Y')}} Ans</td>
                                <td style="text-align: right">{{$inscription->student->classe->name.' '.$classe->option->name}}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
