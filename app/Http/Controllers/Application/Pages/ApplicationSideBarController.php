<?php

namespace App\Http\Controllers\Application\Pages;

use App\Http\Controllers\Controller;
use App\Models\AppLink;
use Illuminate\Http\Request;

class ApplicationSideBarController extends Controller
{
    public function __invoke(AppLink $appLink)
    {
        return view('main-sidebar',compact(['appLink']));
    }
}
