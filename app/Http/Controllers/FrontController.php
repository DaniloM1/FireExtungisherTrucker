<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        // Možeš poslati dodatne podatke u view ako je potrebno
        return view('front.home');
    }
}
