<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Import View class for type hinting

class HomeController extends Controller
{
    public function index(): View // Tentukan bahwa method ini akan mengembalikan sebuah View
    {
        return view('home');
    }
}
