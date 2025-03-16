<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('front.home');
    }

    public function services()
    {
        return view('front.services');
    }

    public function inspection()
    {
        return view('front.services.inspection');
    }

    public function protection()
    {
        return view('front.services.protection');
    }

    public function evacuation()
    {
        return view('front.services.evacuation');
    }

    public function installation()
    {
        return view('front.services.installation');
    }

    public function exam()
    {
        return view('front.services.exam');
    }

    public function training()
    {
        return view('front.services.training');
    }

    public function aboutUs()
    {
        return view('front.aboutUs');
    }

    public function contact()
    {
        return view('front.contact');
    }
}
