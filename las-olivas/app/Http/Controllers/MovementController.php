<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovementController extends Controller
{
 
    public function index()
    {
        $clients = Client::select()->orderBy('name', 'ASC')->get();
        if (count($clients) > 0) 
        {
            return view('movements-dashboard')->withClients($clients);
        }
        return view('movements-dashboard');
    }

    public function list_client_movements(Request $request)
    {
        $client_id = $request->input('client_id');
        $client = Client::where('id', $client_id)->get();


        $movements = Movement::where('client_id', $client_id)->select()->orderBy('created_at', 'DESC');

        if (count($movements->get()) == 0)
        {
            return view('movements-client-list')->withClient($client)->withMessage('El cliente no tiene ningún movimiento aún.');
        }

        $from = $request->input('from');
        $to = $request->input('to');

        if ($from != null and $to != null)
        {
            $movements = $movements->whereBetween('created_at', [$from, $to]);

            if (count($movements->get()) == 0)
            {
                return view('movements-client-list')->withClient($client)->withMessage('El cliente no tiene movimientos en las fechas seleccionadas.');
            }
        }

        $movements = $movements->paginate(15);

        return view('movements-client-list')->withClient($client)->withMovements($movements);
    }

    private function validate_new_movement(Request $request)
    {
        return Validator::make($request->all(), [
            'client_id' => ['required', 'bail', 'exists:clients,id'],
            'description' => ['required', 'string', 'max:200'],
            'receipt_type' => ['required', 'string', 'max:50', 'regex:/^([^0-9]*)$/'],
            'date' => ['required'],
            'due' => ['required', 'numeric', 'gt:0'],
            'paid' => ['required', 'numeric', 'gt:0']
        ]);
    }

    public function add_movement(Request $request)
    {
        $movement_validation = $this->validate_new_movement($request);

        if ($movement_validation->fails())
        {
            return $this->index()->withMessage('Algún dato que se deseó cargar fue incorrecto.');
        }

        $client = Client::where('id', $request->input('client_id'))->select()->first();
        $client->calculate_new_balance($request->input('due'), $request->input('paid'));
        $client->save();

        Movement::create([
            'description' => $request->input('description'),
            'receipt_type' => $request->input('receipt_type'),
            'due' => $request->input('due'),
            'paid' => $request->input('paid'),
            'balance' =>  $client->current_balance,
            'client_id' => $request->input('client_id'),
            'created_at' => $request->input('date')
        ]);

        return $this->index()->withSuccessMessage('El movimiento se cargó correctamente.');
    }
}
