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
            <span>REQUISITION</span>
        </div>
        <div>
            <span style="font-weight: bold">Numero:</span>
            <span>{{$requisition->code}}</span>
        </div>
        <div>
            <span style="font-weight: bold">Emise par: </span>
            <span>{{$requisition->emetter->name}}</span>
        </div>
        <div>
            <span style="font-weight: bold">Source : </span>
            <span>{{$requisition->source->name}}</span>
        </div>
        <div>
            <span style="font-weight: bold">Date: </span>
            <span>{{$requisition->created_at->format('d/m/Y')}}</span>
        </div>
    </div>
    <div style="margin-top: 0px">
        @php
            $total=0;
        @endphp
        @if ($requisition->active==false)
            <div style="text-align: center">
                <h3 style="color: gray">Cette requisition n'est pluse encore validée</ style="color: gray">
            </div>
        @else
            <table>
                <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                    <tr>
                        <th style="text-align: center">N°</th>
                        <th style="text-align: left">Désignation</th>
                        <th style="text-align: right">Prix CDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisition->details as $index => $detail)
                        @if ($detail->active==true)
                            <tr>
                                <td style="text-align: center;width: 40px">{{$index+1}}</td>
                                <td style="">{{$detail->description}}</td>
                                <td style="text-align: right">{{$detail->amount}}</td>
                            </tr>
                            @php
                                $total+=$detail->amount;
                            @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: right;font-size: 20px;margin-top: 10px;">
                <span style="font-weight: bold">Total: </span><span>{{ number_format($total,1,',',' ') }} Fc</span>
                <div style="margin-top: 8px">
                    <span style="">Fiat à Lubumbashi,Le {{date('d/m/Y')}}</span>
                </div>
            </div>
            <div style="font-size: 18px;margin-top: 20px; padding: 8px;color: rgb(32, 32, 32)">
                <span style="font-weight: bold;margin-right: 400px">COMPTABLE</span>
                <span style="font-weight: bold">COORDONATEUR</span>
            </div>
        @endif
    </div>
</body>
</html>
