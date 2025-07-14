<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Import View class for type hinting
use App\Models\product;

class HomeController extends Controller
{
    public function index(): View // Tentukan bahwa method ini akan mengembalikan sebuah View
    {
        $product = product::paginate(4);
        return view('home', compact('product'));
    }
}
