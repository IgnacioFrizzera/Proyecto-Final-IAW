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
        $clients = Client::all();
        if (count($clients) > 0) 
        {
            return view('movements-dashboard')->withClients($clients);
        }
        return view('movements-dashboard');
    }

    public function list_client_movements(Request $request)
    {
        $client = Client::where('id', $request->input('client_id'))->get();
        $movements = Movement::where('client_id', $request->input('client_id'))->select()->paginate(15);
        
        if(count($movements) == 0)
        {
            return view('movements-client-list')->withClient($client)->withMessage('El cliente no tiene ningún movimiento aún.');
        }

        return view('movements-client-list')->withClient($client)->withMovements($movements);
    }

    private function validate_new_movement(Request $request)
    {
        return Validator::make($request->all(), [
            'client_id' => ['required', 'bail', 'exists:clients,id'],
            'description' => ['required', 'string', 'max:200'],
            'receipt_type' => ['required', 'string', 'max:50', 'regex:/^([^0-9]*)$/'],
            'due' => ['required', 'numeric'],
            'paid' => ['required', 'numeric'],
            'balance' => ['required', 'numeric']
        ]);
    }

    public function add_movement(Request $request)
    {
        $movement_validation = $this->validate_new_movement($request);

        if ($movement_validation->fails())
        {
            return $this->index()->withMessage('Algún dato que se deseó cargar fue incorrecto.');
        }

        Movement::create([
            'description' => $request->input('description'),
            'receipt_type' => $request->input('receipt_type'),
            'due' => $request->input('due'),
            'paid' => $request->input('paid'),
            'balance' => $request->input('balance'),
            'client_id' => $request->input('client_id')
        ]);

        return redirect()->action(
            [MovementController::class, 'list_client_movements'],
            ['client_id' => $request->input('client_id')]
        );
    }
}