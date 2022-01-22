<?php

namespace App\Http\Controllers;

use App\Models\MonthlySale;
use Illuminate\Http\Request;

class MonthlySalesController extends Controller
{

    public function index()
    {
        return view('add-previous-monthly-sale');
    }

    private function validate_date($month, $year)
    {
        $current_year = date('Y');
        if ($current_year != $year) return true;

        $current_month = date('m');
        if ($current_month <= $month) return false;
        
        return true;
    }

    public function add_monthly_sale(Request $request)
    {
        $given_month = $request->input('month');
        $given_year = $request->input('year');

        if (!$this->validate_date($given_month, $given_year)) 
        {
            return $this->index()->withInvalidDate('No se pueden cargar ventas del actual mes o meses futuros.');
        }

        MonthlySale::create([
            'month' => $given_month,
            'year' => $given_year,
            'fc' => $request->input('fc_sales'),
            'fcc' => $request->input('fcc_sales'),
            'ef' => $request->input('ef_sales'),
            'tc' => $request->input('tc_sales'),
            'td' => $request->input('td_sales')
        ]);
        
        return $this->index()->withMessage('Ventas cargadas');
    }
}
