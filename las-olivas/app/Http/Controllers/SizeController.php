<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Size;

class SizeController extends Controller
{
    
    public function index()
    {
        return view('labels');
    }

    private function validate_name($name)
    {
        return Validator::make(['name' => $name], [
            'name' => ['required', 'string', 'max:50', 'unique:sizes']
        ]);
    }

    public function add(Request $request)
    {
        $normalized_name = strtoupper($request->input('size_name'));
        $validated_size = $this->validate_name($normalized_name);

        if ($validated_size->fails())
        {
            return $this->index()->withSizeError('Ya existe un talle con ese nombre');
        };
        
        Size::create([
            'name' => $normalized_name
        ]);

        return $this->index()->withSuccessMessage('Talle creado');
    }
}
