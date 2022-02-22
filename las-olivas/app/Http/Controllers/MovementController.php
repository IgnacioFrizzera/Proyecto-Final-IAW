<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Movement;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovementController extends Controller
{
 
    public function index()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $sizes = Size::all();

        $clients = Client::all()->sortBy([
            'last_name', 'ASC',
            'name', 'ASC'
        ]);
        
        if (count($clients) > 0)
        {
            return view('movements-dashboard', compact('clients', 'brands', 'categories', 'sizes'));
        }

        return view('movements-dashboard', compact('brands', 'categories', 'sizes'));
    }
    
    public function list_client_movements(Request $request)
    {
        $client_id = $request->client_id;
        $client = Client::where('id', $client_id)->get();

        $movements = Movement::where('client_id', $client_id)->select()->orderBy('created_at', 'DESC')->orderBy('id', 'DESC');

        if (count($movements->get()) == 0)
        {
            return view('movements-client-list')->withClient($client)->withMessage('El cliente no tiene ningún movimiento aún.');
        }

        $from = $request->from;
        $to = $request->to;

        if ($from != null and $to != null)
        {
            $movements = $movements->whereBetween('created_at', [$from, $to])->get();

            if (count($movements) == 0)
            {
                return view('movements-client-list')->withClient($client)->withMessage('El cliente no tiene movimientos en las fechas seleccionadas.');
            }

            return view('movements-client-list')->withClient($client)->withMovements($movements);
        }

        $movements = $movements->get();
        
        return view('movements-client-list')->withClient($client)->withMovements($movements);
    }

    private function validate_new_movement(Request $request)
    {
        return Validator::make($request->all(), [
            'client_id' => ['bail', 'exists:clients,id'],
            'description' => ['required', 'string', 'max:200'],
            'receipt_type' => ['required', 'string', 'max:50', 'regex:/^([^0-9]*)$/'],
            'date' => ['required'],
            'due' => ['required', 'numeric'],
            'paid' => ['required', 'numeric'],
            'category' => ['required', 'exists:categories,id'],
            'brand' => ['required', 'exists:brands,id'],
            'size' => ['required', 'exists:sizes,id'],
            'extra_commentary' => ['string', 'max:100'],
            'promotion' => ['required', 'string']
        ]);
    }

    public function add_movement(Request $request)
    {
        $movement_validation = $this->validate_new_movement($request);

        if ($movement_validation->fails())
        {
            return $this->index()->withMessage('Algún dato que se deseó cargar fue incorrecto.');
        }

        // add this logic/checking in the frontend
        if (($request->client_name != null || $request->client_last_name != null) and $request->client_id != null)
        {   
            return $this->index()->withMessage('No se puede seleccionar un cliente y cargar un cliente a la vez.');
        }

        if ($request->client_name != null and $request->client_last_name != null)
        {
            $client = Client::create([
                'name' => $request->client_name,
                'last_name' => $request->client_last_name
            ]);
        }
        elseif ($request->client_id != null)
        {
            $client = Client::where('id', $request->client_id)->select()->first();
        }
        else
        {
            return $this->index()->withMessage('Algún dato que se deseó cargar fue incorrecto.');
        }

        $client->calculate_new_balance($request->due, $request->paid);
        $client->save();

        Movement::create([
            'description' => $request->description,
            'receipt_type' => $request->receipt_type,
            'due' => $request->due,
            'paid' => $request->paid,
            'balance' =>  $client->current_balance,
            'client_id' => $client->id,
            'category_id' => $request->category,
            'brand_id' => $request->brand,
            'size_id' => $request->size,
            'extra_comentary' => $request->extra_comentary,
            'paid_with_promotion' => $request->promotion,
            'created_at' => $request->date
        ]);

        if ($request->receipt_type == 'FC')
        {
            // Creates the instant payment movement for the 'FC' movement.
            $client->calculate_new_balance($request->paid, $request->due);
            $client->save();
            
            Movement::create([
                'description' => $request->description,
                'receipt_type' => $request->payment_type,
                'due' => $request->paid,
                'paid' => $request->due,
                'balance' =>  $client->current_balance,
                'client_id' => $client->id,
                'category_id' => $request->category,
                'brand_id' => $request->brand,
                'size_id' => $request->size,
                'extra_comentary' => $request->extra_comentary,
                'paid_with_promotion' => $request->promotion,
                'created_at' => $request->date
            ]);
        }

        return $this->index()->withSuccessMessage('El movimiento se cargó correctamente.');
    }
}
