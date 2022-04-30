<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movement;


class SalesController extends Controller
{

    private function sum_due($movements)
    {  
        $sum = 0;
        foreach ($movements as $movement)
        {
            $sum += $movement->due;
        }
        return $sum;
    }

    private function sum_paid($movements)
    {
        $sum = 0;
        foreach ($movements as $movement)
        {
            $sum += $movement->paid;
        }
        return $sum;
    }

    private function calculate_monthly_fc($movements)
    {
        $filtered_movements = $movements->where('receipt_type', 'FC');
        return $this->sum_due($filtered_movements);
    }

    private function calculate_monthly_fcc($movements)
    {
        $filtered_movements = $movements->where('receipt_type', 'FCC');
        return $this->sum_due($filtered_movements);
    }

    private function calculate_monthly_ef($movements)
    {
        $filtered_movements = $movements->where('receipt_type', 'EF');
        return $this->sum_paid($filtered_movements);
    }

    private function calculate_monthly_tc($movements)
    {
        $filtered_movements = $movements->where('receipt_type', 'TC');
        return $this->sum_paid($filtered_movements);
    }

    private function calculate_monthly_td($movements)
    {
        $filtered_movements = $movements->where('receipt_type', 'TD');
        return $this->sum_paid($filtered_movements);
    }

    private function calculate_sales($movements)
    {
        return [
            'fc' => $this->calculate_monthly_fc($movements),
            'fcc' => $this->calculate_monthly_fcc($movements),
            'ef' => $this->calculate_monthly_ef($movements),
            'tc' => $this->calculate_monthly_tc($movements),
            'td' => $this->calculate_monthly_td($movements)
        ];
    }

    public function calculate_monthly_sales(string $month, string $year)
    {
        $movements = Movement::whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        return $this->calculate_sales($movements);
    }

    public function calculate_daily_sales($movements)
    {
        return $this->calculate_sales($movements);
    }
}
