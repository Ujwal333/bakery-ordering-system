<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function browseMenu()
    {
        return view('browse-menu');
    }

    public function customCake()
    {
        return view('custom-cake');
    }

    public function orderTracking()
    {
        return view('order-tracking');
    }

    public function about()
    {
        return view('about');
    }

    public function features()
    {
        return view('features');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }
}
