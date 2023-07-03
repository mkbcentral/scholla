<?php

namespace App\Http\Controllers\Application\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationDashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard');
    }
}
