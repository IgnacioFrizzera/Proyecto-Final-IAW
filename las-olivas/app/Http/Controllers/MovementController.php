<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Movement;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JavaScript;

class MovementController extends Controller
{
 
    public function index()
    {
        $brands = Brand::select()->orderBy('name', 'ASC')->get();
        $categories = Category::select()->orderBy('name', 'ASC')->get();
        $sizes = Size::select()->orderBy('name', 'ASC')->get();

        $clients = Client::all()->sortBy([
            'name', 'ASC',
            'last_name', 'ASC'
        ]);
        
        JavaScript::put([
            'clients' => $clients,
            'brands' => $brands,
            'categories' => $categories,
            'sizes' => $sizes,
        ]);

        if (count($clients) > 0)
        {
            return view('movements-dashboard', compact('clients', 'brands', 'categories', 'sizes'));
        }

        return view('movements-dashboard', compact('brands', 'categories', 'sizes'));
    }
    
    public function list_client_movements(Request $request)
    {
        return $this->return_client_movements_view($request->client_id, $request->from , $request->to);
    }

    private function return_client_movements_view($client_id, $from=null, $to=null)
    {
        $client = Client::where('id', $client_id)->get();

        $movements = Movement::where('client_id', $client_id)
                        ->join('categories', 'movements.category_id', '=', 'categories.id')
                        ->join('brands', 'movements.brand_id', '=', 'brands.id')
                        ->join('sizes', 'movements.size_id', '=', 'sizes.id')
                        ->select('movements.id', 'movements.created_at', 'movements.description', 'movements.receipt_type', 
                        'movements.due', 'movements.paid', 'movements.balance', 'categories.name as category_name', 
                        'brands.name as brand_name', 'sizes.name as size_name')
                        ->orderBy('movements.created_at', 'DESC')
                        ->orderBy('movements.id', 'DESC');

        if (count($movements->get()) == 0)
        {
            return view('movements-client-list')->withClient($client)->withMessage('El cliente no tiene ningún movimiento aún.');
        }

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

    public function add_movement(Request $request)
    {        
        if (($request->client_name != null || $request->client_last_name != null) and $request->client_id != null)
        {   
            return $this->index()->withMessage('No se puede seleccionar un cliente y cargar un cliente a la vez.');
        }

        if ($request->client_name != null and $request->client_last_name != null)
        {
            $client_with_same_name_lastname = 
                Client::where('name', strtoupper($request->client_name))
                        ->where('last_name', strtoupper($request->client_last_name))->get();
            
            if (count($client_with_same_name_lastname) != 0)
            {
                return $this->index()->withMessage('Ya existe un cliente con ese nombre y apellido.');
            }

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

        $description = $request->description;
        $receipt_type = $request->receipt_type;
        $client_id = $client->id;
        $paid_with_promotion = $request->promotion;
        $creation_date = $request->date;
        $payment_type = $request->payment_type;

        $index = 0;
        while ($request->input('category'.$index) != null)
        {
            $category_id = $request->input('category'.$index);
            $brand_id = $request->input('brand'.$index);
            $size_id = $request->input('size'.$index);
            $price_item = $request->input('priceItem'.$index);

            $client->calculate_new_balance($price_item, 0);
            $client->save();

            Movement::create([
                'client_id' => $client_id,
                'description' => $description,
                'receipt_type' => $receipt_type,
                'due' => $price_item,
                'paid' => 0,
                'balance' => $client->current_balance,
                'category_id' => $category_id,
                'brand_id' => $brand_id,
                'size_id' => $size_id,
                'paid_with_promotion' => $paid_with_promotion,
                'created_at' => $creation_date
            ]);

            if ($receipt_type == "FC")
            {
                $client->calculate_new_balance(0, $price_item);
                $client->save();

                Movement::create([
                    'client_id' => $client_id,
                    'description' => $description.' - Pago',
                    'receipt_type' => $payment_type,
                    'due' => 0,
                    'paid' => $price_item,
                    'balance' => $client->current_balance,
                    'category_id' => $category_id,
                    'brand_id' => $brand_id,
                    'size_id' => $size_id,
                    'paid_with_promotion' => $paid_with_promotion,
                    'created_at' => $creation_date
                ]);
            }

            $index += 1;
        }

        return $this->index()->withSuccessMessage('El movimiento se cargó correctamente.');
    }

    public function delete_movement(Request $request)
    {   
        $movement = Movement::where('id', $request->movement_id)->select()->first();
        $client = Client::where('id', $request->client_id)->select()->first();
        $client->recalculate_balance($movement);
        $client->save();
        $movement->delete();

        return $this->return_client_movements_view($request->client_id);
    }
}
