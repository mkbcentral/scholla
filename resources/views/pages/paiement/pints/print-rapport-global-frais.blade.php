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
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
@php
$total=0;
$total_fonctionnement=0;
$total_bank=0;
$total_depense=0;
$solde=0;
@endphp
<body>
    <div style="border: 1px solid black;padding: 6px">
        <div style="text-align: center;padding: 15px;font-size: 22px">
            <span style="text-transform: uppercase">SITUATION ANNUELLE DE PAIMENT DES FRAIS {{$motif.'/'.$myTypeData}}</span>
        </div>
        <div>
            <span>Motifs: {{$motif}}</span>
        </div>
        @if ($classe !=null)
            <span>Classe: {{$classe->name.'/'.$classe->option->name}}</span>
        @endif
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
                    <table >
                        <thead style="background: rgb(67, 67, 67);color: rgb(222, 221, 221)">
                            <tr>
                                <th>N°</th>
                                <th>DATE</th>
                                <th>CODE</th>
                                <th>ELEVE</th>
                                <th style="text-align: right">TYPE</th>
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
                                    <td style="text-align: right">{{$paiment->cost->name }}</td>
                                    <td style="text-align: right">
                                        @if ($paiment->cost->amount==0)
                                            Exampté
                                        @else
                                            {{number_format($paiment->cost->amount*$taux,1,',',' ') }}</td>
                                        @endif

                                </tr>
                                @php
                                    if ($paiment->depense) {
                                                if ($paiment->is_bank==true){
                                                $total_bank+=$paiment->cost->amount*2000-$paiment->depense->amount;
                                            }

                                            elseif ($paiment->is_fonctionnement==true)
                                            {
                                                $total_fonctionnement+=$paiment->cost->amount*2000-$paiment->depense->amount;
                                            }
                                            elseif ($paiment->is_depense==true)
                                                {
                                                    $total_depense+=$paiment->cost->amount*2000-$paiment->depense->amount;
                                                }
                                            $total+=$paiment->cost->amount*2000-$paiment->depense->amount;
                                        } else {
                                            if ($paiment->is_bank==true){
                                                    $total_bank+=$paiment->cost->amount*2000;
                                                }

                                                elseif ($paiment->is_fonctionnement==true)
                                                {
                                                    $total_fonctionnement+=$paiment->cost->amount*2000;
                                                }
                                                elseif ($paiment->is_depense==true)
                                                    {
                                                        $total_depense+=$paiment->cost->amount*2000;
                                                    }
                                                $total+=$paiment->cost->amount*2000;
                                        }
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    @php
                        $solde=$total-$total_bank-$total_depense-$total_fonctionnement;
                    @endphp
                    @endif
    <div >
        <div style="margin-top: 12px" >
            <table class="table table-stripped">
                <tbody>
                    <tr class=" text-bold" >
                        <td style="font-size: 22px;font-weight: bold; text-align: left">Total</td>
                        <td style="font-size: 22px;font-weight: bold; text-align: right">Dép. baque</td>
                        <td style="font-size: 22px;font-weight: bold; text-align: right">Fonct.</td>
                        <td style="font-size: 22px;font-weight: bold; text-align: right">Autres dép.</td>
                        <td style="font-size: 22px;font-weight: bold; text-align: right">Solde</td>
                    </tr>
                    <tr class="text-bold">
                        <td style="font-size: 20px;;text-align: left;background: rgb(38, 38, 39);color: white">{{number_format($total,1,',',' ')}} Fc</td>
                        <td style="font-size: 20px;;text-align: right">{{number_format($total_bank,1,',',' ')}} Fc</td>
                        <td style="font-size: 20px;;text-align: right">{{number_format($total_fonctionnement,1,',',' ')}} Fc</td>
                        <td style="font-size: 20px;;text-align: right">{{number_format($total_depense,1,',',' ')}} FC</td>
                        <td style="font-size: 20px;;text-align: right;background: rgb(8, 8, 15);color: white">{{number_format($solde,1,',',' ')}} Fc</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="margin-top: 10px;text-align: right">
            <span style="">Fiat à Lubumbashi,Le {{date('d/m/Y')}}</span>
        </div>
        <div style="font-size: 18px;margin-top: 20px; padding: 8px;color: rgb(32, 32, 32)">
            <span style="font-weight: bold;margin-right: 550">COMPTABLE</span>
            <span style="font-weight: bold">COORDONATEUR</span>
        </div>
    </div>

</body>
</html>
