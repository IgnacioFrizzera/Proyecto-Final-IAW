<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();

        if(count($clients) == 0)
        {
            return view('clients-dashboard')->withMessage('No hay clientes cargados en el sistema');
        }

        return view('clients-dashboard')->withClients($clients);
    }

    public function index_add_client()
    {
        return view('clients-add');
    }

    private function update_client(Request $request)
    {
        $client_current_info = [
            'current_name' => $request->client_name,
            'current_last_name' => $request->client_last_name,
            'current_email' => $request->client_email,
            'current_phone_number' => $request->client_phone_number
        ];
        return view('clients-update')->withClientCurrentInfo($client_current_info);
    }

    private function delete_client($request)
    {
        Client::where('id', $request->client_id)->delete();
        return $this->index()->withDeleteMessage('Se ha eliminado al cliente correctamente');
    }

    private function validate_client(Request $request)
    {
        return Validator::make($request->all(), [
            'client_name' => ['required', 'string', 'max:100'],
            'client_last_name' => ['required', 'string', 'max:100'],
            'phone_number' => ['unique:clients', 'max:20'],
            'email' => ['email', 'unique:clients', 'max:100']
        ]);
    }

    public function add_client(Request $request)
    {
        $validation = $this->validate_client($request);
        
        if($validation->fails()){
            return $this->index_add_client()->withFailedToCreateMessage('Hubo un error a la hora de cargar al cliente, revise los datos ingresados');
        }

        Client::create([
            'name' => $request->input('client_name'),
            'last_name' => $request->input('client_last_name'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email')
        ]);

        return $this->index();
    }

    public function client_modification(Request $request)
    {
        if($request->action == 'update')
        {
            return $this->update_client($request);
        }
        else if ($request->action == 'delete')
        {
            return $this->delete_client($request);
        }
    }

    public function client_search(Request $request)
    {
        $clients = 
            Client::where('name', 'ilike', '%'.$request->search.'%')
                ->orWhere('last_name', 'ilike', '%'.$request->search.'%')
                ->select('id', 'name', 'last_name', 'email', 'phone_number')
                ->paginate(15);
        
        if(count($clients) == 0)
        {
            return view('clients-dashboard')->withSearchMessage('No se han encontrado clientes');
        }
        return view('clients-dashboard')->withClients($clients); 
    }
}
