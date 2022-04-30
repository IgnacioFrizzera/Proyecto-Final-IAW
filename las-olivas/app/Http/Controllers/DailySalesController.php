<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class DailySalesController extends Controller
{
    public function index()
    {
        
        return view('daily-sales');
    }
}
