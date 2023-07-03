<?php

namespace App\Http\Controllers\Application\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationLinkController extends Controller
{
    public function __invoke()
    {
        return view('main');
    }
}
