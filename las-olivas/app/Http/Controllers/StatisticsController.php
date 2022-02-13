<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Movement;

use JavaScript;

class StatisticsController extends Controller
{

    public function index()
    {
        $total_balance = $this->calculate_total_balance();
        $total_clients = $this->total_clients();
        $movements = Movement::select('receipt_type', 'due', 'paid', 'size_id', 'paid_with_promotion')->get();

        JavaScript::put([
            'movements' => $movements,
        ]);

        return view('dashboard', compact('total_balance', 'total_clients'));
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
