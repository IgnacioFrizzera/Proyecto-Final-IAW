<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Movement;
use Illuminate\Http\Request;

use PDF;

class PDFController extends Controller
{
    
    public function create_pdf($client, $movements, $last_month_balance=null)
    {
        $data = [
            'client_data' => $client,
            'client_movements' => $movements,
            'last_month_balance' => $last_month_balance,
        ];
        
        $pdf = PDF::loadView('/pdf/client-movements-pdf', $data);
        
        return $pdf;
    }

    public function download_pdf(Request $request)
    {
        $client_id = $request->input('client_id');
        
        $client = Client::where('id', $client_id)->select()->first();
        $movements = Movement::where('client_id', $client_id)->get();

        $pdf = $this->create_pdf($client, $movements);
        return $pdf->download($client->name . ' ' . $client->last_name . '.pdf');
    }
}
