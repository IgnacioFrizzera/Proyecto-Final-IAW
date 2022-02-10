<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::select()->orderBy('current_balance', 'DESC')->paginate(10);
        
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

    private function validate_client_personal_info(Request $request)
    {
        return Validator::make($request->all(), [
            'client_name' => ['required', 'string', 'max:100', 'regex:/^([^0-9]*)$/'],
            'client_last_name' => ['required', 'string', 'max:100', 'regex:/^([^0-9]*)$/'],
            'client_address' => ['string', 'nullable', 'max:100'],
            'client_profession' => ['string', 'nullable', 'max:100', 'regex:/^([^0-9]*)$/']
        ]);
    }

    private function validate_client_contact_info(Request $request)
    {
        return Validator::make($request->all(), [
            'phone_number' => ['unique:clients', 'max:20', 'nullable'],
            'email' => ['email', 'unique:clients', 'max:100', 'nullable']
        ]);
    }

    public function add_client(Request $request)
    {
        $personal_info_validation = $this->validate_client_personal_info($request);
        $contact_info_validation = $this->validate_client_contact_info($request);
        
        if($personal_info_validation->fails())
        {
            return $this->index_add_client()->withFailedToCreateMessage('Revise el: nombre, apellido o profesión que intentó cargar.');
        }

        if($contact_info_validation->fails())
        {
            return $this->index_add_client()->withFailedToCreateMessage('Ya existe un usuario con el email o teléfono ingresados.');
        }

        Client::create([
            'name' => $request->input('client_name'),
            'last_name' => $request->input('client_last_name'),
            'phone_number' => $request->input('phone_number'),
            'email' => $request->input('email'),
            'birthday' => $request->input('client_birthday'),
            'address' => $request->input('client_address'),
            'profession' => $request->input('client_profession')
        ]);

        return $this->index();
    }

    public function update_client(Request $request)
    {
        $client = Client::where('id', $request->input('id'))->get();

        if(count($client) == 0){
            return $this->update_client_index($request)->withFailedToUpdate('El cliente dejó de existir.');
        }

        $personal_info_validation = $this->validate_client_personal_info($request);
        
        if ($personal_info_validation->fails())
        {
            $this->update_client_index($request)->withFailedToUpdate('Revise el: nombre, apellido o profesión que intentó actualizar.');
        }

        try 
        {
            Client::where('id', $request->input('id'))->update([
                'name' => $request->input('client_name'),
                'last_name' => $request->input('client_last_name'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'birthday' => $request->input('client_birthday'),
                'address' => $request->input('client_address'),
                'profession' => $request->input('client_profession')
            ]);
        }
        catch (QueryException $e)
        {
            return $this->update_client_index($request)->withFailedToUpdate('Ya existe algún usuario con el email o teléfono que intentó actualizar.');   
        }

        return $this->index()->withMessage('Se actualizaron correctamente los datos del cliente');
    }

    public function update_client_index(Request $request)
    {
        $clientData = Client::where('id', $request->id)->get();
        return view('clients-update')->withClientData($clientData);
    }

    public function delete_client(Request $request)
    {
        Client::where('id', $request->id)->delete();
        return $this->index()->withMessage('Se ha eliminado al cliente correctamente');
    }

    public function client_search(Request $request)
    {
        $clients = 
            Client::where('name', 'ilike', '%'.$request->search.'%')
                ->orWhere('last_name', 'ilike', '%'.$request->search.'%')
                ->select('id', 'name', 'last_name', 'email', 'phone_number', 'current_balance')
                ->paginate(15);
        
        if(count($clients) == 0)
        {
            return view('clients-dashboard')->withMessage('No se han encontrado clientes');
        }
        return view('clients-dashboard')->withClients($clients); 
    }
}
