<?php

namespace App\Http\Controllers;

use App\Models\DepotBank;
use App\Models\ScolaryYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class MouvementBankController extends Controller
{
    public function printDepotBank($month){
        $depots=DepotBank::whereMonth('created_at',$month)->where('active',true)->get();
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.bak.prints.print-depot-bank',
            compact(['defaultScolaryYer','depots','month']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('depot.pdf');
            return $pdf->stream();
    }

    public function printDepotBankAll(){
        $depots=DepotBank::where('active',true)->get();
        $defaultScolaryYer=ScolaryYear::where('active',true)->first();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.bak.prints.print-depot-bank-all',
            compact(['defaultScolaryYer','depots']))
            ->setPaper('a4', 'landscape')->setWarnings(false)->save('depot.pdf');
            return $pdf->stream();
    }
}
