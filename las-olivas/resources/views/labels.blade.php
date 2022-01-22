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
                        <form action="{{route('labels-add-category')}}" method="POST" enctype="multipart/form-data">
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
                        <form action="{{route('labels-add-brand')}}" method="POST" enctype="multipart/form-data">
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
                        <form action="{{route('labels-add-size')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <input required type="string" class="form-control" name="size_name" placeholder="Talle" maxlength="50">
                                </div>
                                <div class="col-4">
                                    <button type="sumbit" class="btn btn-dark">Cargar talle</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>