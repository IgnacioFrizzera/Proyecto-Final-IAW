<!-- Font Awesome Brand Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Carga de categorías, marcas y talles') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1>
                        Carga de marcas, categorías y talles
                    </h1>
                    @if(isset($successMessage))
                        <h3>
                            <hr>
                            {{$successMessage}}
                        </h3>
                    @endif
                    <hr>
                    <div>
                        <h2>Categorías</h2>
                        @if(isset($categoryError))
                            <h4 style="color:red; text-decoration:underline">
                                {{$categoryError}}
                            </h4>
                        @endif                            
                        <form action="{{route('add-category')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <input required type="string" class="form-control" name="category_name" placeholder="Categoría" maxlength="50">
                                </div>
                                <div class="col-4">
                                    <button type="sumbit" class="btn btn-dark">Cargar categoría</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div>
                        <h2>Marcas</h2>
                        @if(isset($brandError))
                            <h4 style="color:red; text-decoration:underline">
                                {{$brandError}}
                            </h4>
                        @endif
                        <form action="{{route('add-brand')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <input required type="string" class="form-control" name="brand_name" placeholder="Marca" maxlength="50">
                                </div>
                                <div class="col-4">
                                    <button type="sumbit" class="btn btn-dark">Cargar marca</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div>
                        <h2>Talles</h2>
                        @if(isset($sizeError))
                            <h4 style="color:red; text-decoration:underline">
                                {{$sizeError}}
                            </h4>
                        @endif
                        <form action="{{route('add-size')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <input required type="string" class="form-control" name="size_name" placeholder="Talle" maxlength="10">
                                </div>
                                <div class="col-4">
                                    <button type="sumbit" class="btn btn-dark">Cargar talle</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <hr>
                    <h1>Etiquetas cargadas en el sistema</h1>
                    @if(isset($deleteError))
                        <h4 style="color:red; text-decoration:underline">
                            {{$deleteError}}
                        </h4>
                    @endif  
                    <div class="form-group row">
                        <div class="col-4">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" style="font-size:24px;">Categorías</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <form action="{{route('delete-category')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$category->id}}">
                                                    <th>{{$category->name}}</th>
                                                    <th><button type="sumbit" title="Eliminar categoría" onclick="return confirm('¿Estas seguro que deseas eliminar la categoría?')"><i class="fa fa-minus-circle" style="font-size:24px"></i></button></th>
                                            </form>
                                            <form action="{{route('modify-category')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$category->id}}">
                                                <th><button type="sumbit" title="Modificar categoría"><i class="fa fa-pencil" style="font-size:24px"></i></button></th>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-4">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" style="font-size:24px;">Marcas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brands as $brand)
                                        <tr>
                                            <form action="{{route('delete-brand')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$brand->id}}">
                                                    <th>{{$brand->name}}</th>
                                                    <th><button type="sumbit" title="Eliminar marca" onclick="return confirm('¿Estas seguro que deseas eliminar la marca?')"><i class="fa fa-minus-circle" style="font-size:24px"></i></button></th>
                                            </form>
                                            <form action="{{route('modify-brand')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$brand->id}}">
                                                <th><button type="sumbit" title="Modificar marca"><i class="fa fa-pencil" style="font-size:24px"></i></button></th>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-4">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col" style="font-size:24px;">Talles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sizes as $size)
                                        <tr>
                                            <form action="{{route('delete-size')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$size->id}}">
                                                    <th>{{$size->name}}</th>
                                                    <th><button type="sumbit" title="Eliminar talle" onclick="return confirm('¿Estas seguro que deseas eliminar el talle?')"><i class="fa fa-minus-circle" style="font-size:24px"></i></button></th>
                                            </form>
                                            <form action="{{route('modify-size')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$size->id}}">
                                                <th><button type="sumbit" title="Modificar talle"><i class="fa fa-pencil" style="font-size:24px"></i></button></th>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>