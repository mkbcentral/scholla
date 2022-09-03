<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        return view('pages.admin.dashbaord');
    }

    public function school(){
        return view('pages.school.school-manager');
    }
    public function cost(){
        return view('pages.school.cost-manager');
    }
    public function inscription(){
        return view('pages.school.inscription-page');
    }
    public function listing(){
        return view('pages.school.inscription-listing-page');
    }
    public function evolutionInscription(){
        return view('pages.school.inscription-evolution');
    }
    public function control(){
        return view('pages.control.control-paiment');
    }
    public function bank(){
        return view('pages.bank.mouvement-bank');
    }
    public function admin(){
        return view('pages.admin.admin');
    }
    public function profile(){
        return view('pages.admin.profile');
    }
    public function settings(){
        return view('pages.admin.setting');
    }
    public function depense(){
        return view('pages.depense.index');
    }
}
