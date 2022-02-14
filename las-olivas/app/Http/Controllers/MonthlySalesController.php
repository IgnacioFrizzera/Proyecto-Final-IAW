<?php

namespace App\Http\Controllers;

use App\Models\MonthlySale;
use Illuminate\Http\Request;

class MonthlySalesController extends Controller
{

    public function index()
    {
        $sales = MonthlySale::select()->paginate(12);
        if (count($sales) > 0)
        {
            return view('add-previous-monthly-sale')->withSales($sales);
        }

        return view('add-previous-monthly-sale');
    }

    private function validate_date($month, $year, $sale_to_update_id=null)
    {
        $sales_with_same_date = MonthlySale::where('month', $month)->where('year', $year)->get();
        $sale = $sales_with_same_date->first();
        if (count($sales_with_same_date) != 0 and $sale->id != $sale_to_update_id) return false;

        $current_year = date('Y');
        if ($current_year != $year) return true;

        $current_month = date('m');
        if ($current_month <= $month) return false;
        
        return true;
    }

    public function add_monthly_sale(Request $request)
    {
        $given_month = $request->month;
        $given_year = $request->year;


        if (!$this->validate_date($given_month, $given_year)) 
        {
            return $this->index()->withInvalidDate('Se intentó cargar una venta con un mes y año de una venta que ya existe. O se intentó cargar una venta con el mes actual o un mes a futuro.');
        }

        MonthlySale::create([
            'month' => $given_month,
            'year' => $given_year,
            'fc' => $request->fc_sales,
            'fcc' => $request->fcc_sales,
            'ef' => $request->ef_sales,
            'tc' => $request->tc_sales,
            'td' => $request->td_sales
        ]);
        
        return $this->index()->withMessage('Venta cargada');
    }

    public function delete_monthly_sale(Request $request)
    {
        MonthlySale::where('id', $request->id)->delete();
        return $this->index()->withMessage('Se ha eliminado la venta correctamente');
    }

    public function update_monthly_sale_index(Request $request)
    {
        $sale = MonthlySale::where('id', $request->id)->get();
        return view('update-previous-monthly-sale')->withSale($sale);
    }

    public function update_monthly_sale(Request $request)
    {
        $sale = MonthlySale::where('id', $request->id)->get()->first();

        $given_month = $request->new_month;
        $given_year = $request->new_year;

        if (!$this->validate_date($given_month, $given_year, $sale->id)) 
        {
            return view('update-previous-monthly-sale')->withSale($sale)->withErrorMessage('No se pueden cargar ventas del actual mes o meses futuros');
        }

        MonthlySale::where('id', $request->id)->update([
            'month' => $given_month,
            'year' => $given_year,
            'fc' => $request->fc_sales,
            'fcc' => $request->fcc_sales,
            'ef' => $request->ef_sales,
            'tc' => $request->tc_sales,
            'td' => $request->td_sales
        ]);

        return $this->index()->withMessage('Se actualizó la venta correctamente');
    }
}
