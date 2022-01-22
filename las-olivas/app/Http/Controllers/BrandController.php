<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;

class BrandController extends Controller
{

    public function index()
    {
        return view('labels');
    }

    private function validate_name($name)
    {
        return Validator::make(['name' => $name], [
            'name' => ['required', 'string', 'max:50', 'unique:brands']
        ]);
    }

    public function add(Request $request)
    {
        $normalized_name = strtoupper($request->input('brand_name'));
        $validated_brand = $this->validate_name($normalized_name);

        if ($validated_brand->fails())
        {
            return $this->index()->withBrandError('Ya existe una marca con ese nombre');
        };
        
        Brand::create([
            'name' => $normalized_name
        ]);

        return $this->index()->withSuccessMessage('Marca creada');
    }
}
