<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Import View class for type hinting


class CartController extends Controller
{
    public function index(): View // Tentukan bahwa method ini akan mengembalikan sebuah View
    {
        return view('cart'); // Pastikan ada view 'cart' yang sesuai
    }
}
