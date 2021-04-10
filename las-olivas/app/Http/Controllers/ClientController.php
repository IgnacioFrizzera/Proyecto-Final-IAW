<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;


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
}
