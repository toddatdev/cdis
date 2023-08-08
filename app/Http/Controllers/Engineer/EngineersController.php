<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;

class EngineersController extends Controller
{
    public function index()
    {
        return view('settings.engineer');
    }
}
