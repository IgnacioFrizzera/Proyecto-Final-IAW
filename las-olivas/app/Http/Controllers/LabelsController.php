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
        $brands = Brand::select()->orderBy('name', 'ASC')->get();
        $categories = Category::select()->orderBy('name', 'ASC')->get();
        $sizes = Size::select()->orderBy('name', 'ASC')->get();

        $total = count($brands) + count($categories) + count($sizes);
        
        if ($total > 0)
        {
            return view('labels', compact('brands', 'categories', 'sizes'));
        }

        return view('labels');
    }

    public function update_index(Request $request)
    {
        if ($request->label_type == 'brand')
        {
            $brand = Brand::where('id', $request->id)->get();
            return view('labels-update')->withTitle('marca')->withLabel($brand)->withType('brand');
        }

        if ($request->label_type == 'category')
        {
            $category = Category::where('id', $request->id)->get();
            return view('labels-update')->withTitle('categoría')->withLabel($category)->withType('category');
        }

        if ($request->label_type == 'size')
        {
            $size = Size::where('id', $request->id)->get();
            return view('labels-update')->withTitle('talle')->withLabel($size)->withType('size');
        }
    }

    public function update(Request $request)
    {
        $new_name = strtoupper($request->new_name);
        $label_id = $request->id;

        if ($request->old_name == $new_name)
        {
            return $this->update_index($request)->withErrorMessage('El nombre nuevo debe ser distinto al actual.');
        }

        if ($request->label_type == 'brand')
        {
            if ($this->validate_label($new_name, 'unique:brands')->fails())
            {
                return $this->update_index($request)->withErrorMessage('Ya existe una marca con ese nombre');
            }
            $this->update_brand($label_id, $new_name);
        }
        
        if ($request->label_type == 'category')
        {
            if ($this->validate_label($new_name, 'unique:categories')->fails())
            {
                return $this->update_index($request)->withErrorMessage('Ya existe una categoría con ese nombre');
            }
            $this->update_category($label_id, $new_name);
        }

        if ($request->label_type == 'size')
        {
            if ($this->validate_label($new_name, 'unique:sizes')->fails())
            {
                return $this->update_index($request)->withErrorMessage('Ya existe un talle con ese nombre');
            }
            $this->update_size($label_id, $new_name);
        }

        return $this->index()->withSuccessMessage('Los datos se actualizaron correctamente');
    }

    private function validate_label($name, $key_rule)
    {
        return Validator::make(['name' => $name], [
            'name' => ['required', 'string', 'max:50', $key_rule]
        ]);
    }

    public function add_brand(Request $request)
    {
        $normalized_name = strtoupper($request->brand_name);
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

    private function update_brand($id, $new_name)
    {
        Brand::where('id', $id)->update([
            'name' => $new_name
        ]);
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
        $normalized_name = strtoupper($request->size_name);
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

    private function update_size($id, $new_name)
    {
        Size::where('id', $id)->update([
            'name' => $new_name
        ]);
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
        $normalized_name = strtoupper($request->category_name);
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

    private function update_category($id, $new_name)
    {
        Category::where('id', $id)->update([
            'name' => $new_name
        ]);
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
