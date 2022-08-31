<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function inscriptionPaiement(){
        return view('pages.paiement.inscription-paiemrent');
    }

    public function costPaiment(){
        return view('pages.paiement.cost-paiement');
    }

    public function rapportPaiementInsc(){
        return view('pages.paiement.rapport-paiement-insc');
    }

    public function rapportPaiementFrais(){
        return view('pages.paiement.rapport-paiement-autres-frais');
    }


}
