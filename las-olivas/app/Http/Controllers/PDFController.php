<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Movement;
use Illuminate\Http\Request;

use PDF;

class PDFController extends Controller
{
    
    public function create_pdf($client, $movements, $last_month_balance=null, $current_balance=null)
    {
        $data = [
            'client_data' => $client,
            'client_movements' => $movements,
            'last_month_balance' => $last_month_balance,
            'current_balance' => $current_balance,
        ];
        
        $pdf = PDF::loadView('/pdf/client-movements-pdf', $data);
        
        return $pdf;
    }

    public function download_pdf(Request $request)
    {
        $client = Client::where('id', $request->input('client_id'))->select()->first();
        
        if (true) // if from to not set -> do this
        {
            $year = date('Y');
            $previous_month = date('m') - 1;
            if ($previous_month == '0')
            {
                $year = $year - 1;
                $previous_month = '12';
            }     
            $pdf = $this->create_monthly_movements_pdf($client, $previous_month);
            return $pdf->download($client->name . $client->last_name . $previous_month . '.' . $year . '.pdf');
        }
        // todo: generate pdf with filtered movements.
    }

    public function create_monthly_movements_pdf(Client $client, string $previous_month)
    {
        $movements = $client->get_month_movements($previous_month);
        $previous_month_balance = $client->get_previous_month_balance($previous_month);
        $current_balance = $movements->sortByDesc('id')->first()->balance;

        return $this->create_pdf($client, $movements, $previous_month_balance, $current_balance);
    }
}
