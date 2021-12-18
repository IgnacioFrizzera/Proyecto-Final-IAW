<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
 
    public function index()
    {
        return view('movements-dashboard');
    }


}
