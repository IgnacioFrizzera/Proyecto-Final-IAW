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

        $movements = Movement::join('categories', 'movements.category_id', '=', 'categories.id')
            ->join('brands', 'movements.brand_id', '=', 'brands.id')
            ->select('movements.receipt_type', 'movements.due', 'movements.paid', 'categories.name as category_name', 
                    'brands.name as brand_name', 'movements.paid_with_promotion', 'movements.created_at')->get();

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
