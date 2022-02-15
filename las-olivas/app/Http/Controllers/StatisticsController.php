<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Movement;
use App\Models\MonthlySale;

use JavaScript;

class StatisticsController extends Controller
{

    public function index()
    {
        $total_balance = $this->calculate_total_balance();
        $total_clients = $this->total_clients();

        $movements = Movement::join('categories', 'movements.category_id', '=', 'categories.id')
            ->join('brands', 'movements.brand_id', '=', 'brands.id')
            ->select('movements.receipt_type', 'movements.due', 'movements.paid', 'categories.name as category_name', 
                    'brands.name as brand_name', 'movements.paid_with_promotion', 'movements.created_at')->get();
        
        $current_month_movements = Movement::join('categories', 'movements.category_id', '=', 'categories.id')
            ->join('brands', 'movements.brand_id', '=', 'brands.id')
            ->whereMonth('movements.created_at', date('m'))
            ->select('movements.receipt_type', 'movements.due', 'movements.paid', 'categories.name as category_name', 
                'brands.name as brand_name', 'movements.paid_with_promotion', 'movements.created_at')->get();

        $current_month_tc_sales = $current_month_movements->where('receipt_type', 'TC')->sum('paid');

        $last_year_sales = MonthlySale::where('year', date('Y')-1)->orderBy('month', 'ASC')->get();
        $current_year_sales = MonthlySale::where('year', date('Y'))->orderBy('month', 'ASC')->get();

        JavaScript::put([
            'movements' => $movements,
            'currentMonthMovements' => $current_month_movements,
            'lastYearSales' => $last_year_sales,
            'currentYearSales' => $current_year_sales
        ]);

        return view('dashboard', compact('total_balance', 'total_clients', 'current_month_tc_sales'));
    }

    private function calculate_total_balance()
    {
        $total_balance = 0;
        $clients = Client::all();        
        foreach ($clients as $client)
        {
            $total_balance += $client->current_balance;
        }
        return $total_balance;
    }

    private function total_clients()
    {
        return count(Client::all());
    }

}
