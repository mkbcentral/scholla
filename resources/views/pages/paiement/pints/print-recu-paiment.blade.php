<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Impression recu</title>
  </head>
  <body style=" margin: 0 auto;
                color: #001028;
                background: #FFFFFF;
                font-family: Consolas, monaco, monospace;
                font-size: 23px;">
   <div>
    <div style="font-weight: bold"><Span>COMPLEX SCOLAIRE AQUILA</Span></div>
    <div><span style="font-weight: bold">Golf Plateau </span></div>
    <div><span style="font-weight: bold">Q.MUKUNTO C/ANNEXE</span></div>
    <br>
        <div>----------------------------------------</div>
        <div><span style="font-weight: bold">N°: {{$paiement->number_paiement}}</span></div>
        <div><span style="font-weight: bold">Nom: {{ $paiement->student->name}}</span></div>
        <div><span style="font-weight: bold">Classe: {{ $paiement->student->classe->name.'/'.$paiement->student->classe->option->name}}</span></div>
        <div><span style="font-weight: bold">Motif:Paiement frais {{$paiement->cost->name}}</span></div>
        <div><span style="font-weight: bold">Date: Le {{$paiement->created_at->format('d-m-Y')}}</span></div>
        <div>----------------------------------------</div>
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th style="margin-left: 0px">DESIGNATION</th>
                    <th style="margin-left: 2px"></th>
                    <th style="margin-left: 2px"></th>
                    <th style="margin-left: 2px"></th>
                    <th style="margin-left: 2px"></th>
                    <th style="margin-left: 2px"></th>
                    <th style="margin-left: 2px"></th>
                    <th style="margin-left: 25px;text-align: center">MONTANT CDF</th>
                </tr>
            </thead>
            <tbody>
                <td style="margin-left: 12px;font-weight: bold">
                    -{{ $paiement->cost->name }}
                </td>
                <td style="margin-left: 12px"></td>
                <td style="margin-left: 12px"></td>
                <td style="margin-left: 12px"></td>
                <td style="margin-left: 12px"></td>
                <td style="margin-left: 12px"></td>
                <td style="margin-left: 12px"></td>
                <td style="margin-left: 12px;font-weight: bold">
                    {{ number_format($paiement->cost->amount*$taux,1,',',' ') }}
                </td>
            </tbody>
        </table>
        <div><span>****************************************</span></div>
        <div >
           <strong style="margin-left: 190px;font-weight: bold"> <span>Net à payer: {{ number_format($paiement->cost->amount*$taux,1,',',' ')}} Fc</span></strong>
        </div>
        <br>
        <div ><span style=";font-weight: bold">*********** Education ! **********</span></div><br><br><br><br><br><br>
   </div>
  </body>
</html>
