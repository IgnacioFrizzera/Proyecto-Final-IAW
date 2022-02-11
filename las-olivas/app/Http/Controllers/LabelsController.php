<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Category;

class LabelsController extends Controller
{
    
    public function index()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $sizes = Size::all();

        $total = count($brands) + count($categories) + count($sizes);
        
        if ($total > 0)
        {
            return view('labels', compact('brands', 'categories', 'sizes'));
        }

        return view('labels');
    }

    private function validate_label($name, $key_rule)
    {
        return Validator::make(['name' => $name], [
            'name' => ['required', 'string', 'max:50', $key_rule]
        ]);
    }

    public function add_brand(Request $request)
    {
        $normalized_name = strtoupper($request->input('brand_name'));
        $validated_brand = $this->validate_label($normalized_name, 'unique:brands');

        if ($validated_brand->fails())
        {
            return $this->index()->withBrandError('Ya existe una marca con ese nombre');
        };
        
        Brand::create([
            'name' => $normalized_name
        ]);

        return $this->index()->withSuccessMessage('Marca creada');
    }

    public function modify_brand(Request $request)
    {
        dd('1');
    }

    public function delete_brand(Request $request)
    {
        try
        {
            Brand::where('id', $request->id)->delete();
            return $this->index();
        }
        catch (QueryException $e)
        {
            return $this->index()->withDeleteError('La marca tiene movimientos asociados, no se puede eliminar. Intente modificando el nombre.');
        }
    }

    public function add_size(Request $request)
    {
        $normalized_name = strtoupper($request->input('size_name'));
        $validated_size = $this->validate_label($normalized_name, 'unique:sizes');

        if ($validated_size->fails())
        {
            return $this->index()->withSizeError('Ya existe un talle con ese nombre');
        };
        
        Size::create([
            'name' => $normalized_name
        ]);

        return $this->index()->withSuccessMessage('Talle creado');
    }

    public function modify_size(Request $request)
    {
        dd('2');
    }

    public function delete_size(Request $request)
    {
        try
        {
            Size::where('id', $request->id)->delete();
            return $this->index();
        }
        catch (QueryException $e)
        {
            return $this->index()->withDeleteError('El talle tiene movimientos asociados, no se puede eliminar. Intente modificando el nombre.');
        }
    }

    public function add_category(Request $request)
    {
        $normalized_name = strtoupper($request->input('category_name'));
        $validated_category = $this->validate_label($normalized_name, 'unique:categories');

        if ($validated_category->fails())
        {
            return $this->index()->withCategoryError('Ya existe una categoría con ese nombre');
        };
        
        Category::create([
            'name' => $normalized_name
        ]);

        return $this->index()->withSuccessMessage('Categoría creada');
    }

    public function modify_category(Request $request)
    {
        dd($request);
    }

    public function delete_category(Request $request)
    {
        try
        {
            Category::where('id', $request->id)->delete();
            return $this->index();
        }
        catch (QueryException $e)
        {
            return $this->index()->withDeleteError('La categoría tiene movimientos asociados, no se puede eliminar. Intente modificando el nombre.');
        }
    }

}
