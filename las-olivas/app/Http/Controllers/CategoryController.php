<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('labels');
    }

    private function validate_name($name)
    {
        return Validator::make(['name' => $name], [
            'name' => ['required', 'string', 'max:50', 'unique:categories']
        ]);
    }

    public function add(Request $request)
    {
        $normalized_name = strtoupper($request->input('category_name'));
        $validated_category = $this->validate_name($normalized_name);

        if ($validated_category->fails())
        {
            return $this->index()->withCategoryError('Ya existe una categoría con ese nombre');
        };
        
        Category::create([
            'name' => $normalized_name
        ]);

        return $this->index()->withSuccessMessage('Categoría creada');
    }
}
