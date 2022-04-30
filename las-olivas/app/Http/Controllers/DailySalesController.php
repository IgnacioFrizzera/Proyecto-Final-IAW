<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;



class DailySalesController extends Controller
{
    /**
     * TODO: Create a DailySale model and then a command to automatically create them.
     */
    public function index()
    {
        $movements = Movement::where('created_at', '=', date('Y-m-d'))->get();
        $sales_controller = new SalesController();
        $daily_sales = $sales_controller->calculate_daily_sales($movements);
        return view('daily-sales', compact('movements', 'daily_sales'));
    }
}
