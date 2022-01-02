<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Movement;
use Illuminate\Http\Request;

use PDF;

class PDFController extends Controller
{
    
    public function create_pdf($client, $movements, $last_month_balance=null, $current_balance=null, $from=null, $to=null)
    {
        $data = [
            'client_data' => $client,
            'client_movements' => $movements,
            'last_month_balance' => $last_month_balance,
            'current_balance' => $current_balance,
            'from' => $from,
            'to' => $to
        ];
        
        $pdf = PDF::loadView('/pdf/client-movements-pdf', $data);
        
        return $pdf;
    }

    public function download_pdf(Request $request)
    {
        $client = Client::where('id', $request->input('client_id'))->select()->first();
        $from = $request->input('from');
        $to = $request->input('to');

        if ($from != null and $to != null)
        {
            $pdf = $this->create_filtered_movements_pdf($client, $from, $to);
            return $pdf->download($client->name . $client->last_name . '.pdf');
        }

        $year = date('Y');
        $previous_month = date('m') - 1;
        if ($previous_month == '0')
        {
            $year = $year - 1;
            $previous_month = '12';
        }
        $pdf = $this->create_monthly_movements_pdf($client, $previous_month, $year);
        return $pdf->download($client->name . $client->last_name . $previous_month . '.' . $year . '.pdf');
    }

    public function create_monthly_movements_pdf(Client $client, string $previous_month, string $year)
    {
        $movements = $client->get_month_movements($previous_month, $year);
        $previous_month_balance = $client->get_previous_month_balance($previous_month, $year);
        $current_balance = $movements->sortByDesc('id')->first()->balance;

        return $this->create_pdf($client, $movements, $previous_month_balance, $current_balance);
    }

    public function create_filtered_movements_pdf(Client $client, string $from, string $to)
    {
        $movements = $client->get_between_movements($from, $to);        
        $previous_balance = 0;
        $current_balance = $movements->sortByDesc('id')->first()->balance;

        $first_id = $movements->first()->id;

        $first_previous_movement = $client->movements()->where('id', $first_id - 1)->first();
        if ($first_previous_movement != null)
        {
            $previous_balance = $first_previous_movement->balance;
        }

        return $this->create_pdf($client, $movements, $previous_balance, $current_balance, $from, $to);
    }
}
