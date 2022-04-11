<!-- Font Awesome Brand Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@include ('jsvars')
<script src="{{ asset('js/addMovement.js') }}"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movimientos de clientes') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2>
                        Cargar un movimiento
                    </h2>
                    <hr>
                    @if(isset($message))
                        <h4 style="color:red; text-decoration:underline">
                            {{$message}}
                        </h4>
                        <hr>
                    @endif
                    @if(isset($successMessage))
                        <h4>
                            {{$successMessage}}
                        </h4>
                        <hr>
                    @endif
                    <form action="{{route('movements-add')}}" method="POST" enctype="multipart/form-data"> 
                    @csrf
                        <div class="row">
                            @if(isset($clients))
                                <div class="col-1">
                                    <h3>Cliente: </h3>
                                </div>
                                <div class="col-3">
                                    <select class="form-select" aria-label="Default select example" name="client_id" id="client_id" onchange="disableClientCreationOnClientSelect(this.value)">
                                        <option value="" selected disabled hidden>Elija un cliente</option>
                                        <option value="">Ninguno</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->name }} {{ $client->last_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8">
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <h3>Nombre</h3>
                                            <input type="string" class="form-control" name="client_name" id="client_name" placeholder="Nombre" maxlength="100" onchange="disableClientSelectionOnClientCreation()">
                                        </div>
                                        <div class="col-6">
                                            <h3>Apellido</h3>
                                            <input type="string" class="form-control" name="client_last_name" id="client_last_name" placeholder="Apellido" maxlength="100" onchange="disableClientSelectionOnClientCreation()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <h3 id="client_balance"></h3>
                                </div>
                            @else
                                <div class="col-6">
                                    <h3>No hay clientes en el sistema.</h3>
                                </div>
                            @endif
                        </div>
                        <hr>
                        <div class="col-8">
                            <div class="form-group row">
                                <div class="col-6">
                                    <h4>Información general</h4>
                                </div>
                                <div class="col-6">
                                    <h4 title="Cliente entrega dinero">Es entrega <input type="checkbox" onchange="markMovementAsPayment(event)"></h4>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Comentario interno</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th><input type="date" class="form-control" name="date" required value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>"></th>
                                    <th>
                                        <textarea class="form-control" required id="description" name="description" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="200"></textarea>
                                    </th>
                                    <th>
                                        <textarea class="form-control" id="extra_comentary" name="extra_comentary" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="200"></textarea>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <h4>Información de etiquetas</h4>
                        <button hidden title="Agregar item" type="button" onClick="appendNewItem()"><i class="fa fa-plus" aria-hidden="true" style="font-size:28px"></i></button>
                        <table class="table table-bordered table-striped text-center" id="items_table">
                            <thead>
                                <tr>
                                    <th scope="col">Categoría</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Talle</th>
                                    <th scope="col" id="delete_labels"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <select class="form-select" aria-label="Default select example" name="category" id="category">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th>
                                        <select class="form-select" aria-label="Default select example" name="brand" id="brand">
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}">
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th>
                                        <select class="form-select" aria-label="Default select example" name="size" id="size">
                                            @foreach($sizes as $size)
                                                <option value="{{ $size->id }}">
                                                    {{ $size->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th>-</th>
                                </tr>
                            </tbody>
                        </table>
                        <h4>Información de pago</h4>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Tipo de comprobante</th>
                                    <th scope="col">Debe</th>
                                    <th scope="col">Haber</th>
                                    <th scope="col">Venta por promoción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        <select class="form-select" aria-label="Default select example" name="receipt_type" id="receipt" onchange="disabledOnReceiptType(this.value)">
                                            <option value="FC">FACTURA</option>
                                            <option value="FCC">F. CUENTA CORRIENTE</option>
                                            <option value="EF">EFECTIVO</option>
                                            <option value="TC">TARJETA C</option>
                                            <option value="TD">TARJETA D</option>
                                        </select>
                                    </th>
                                    <th><input class="form-control"required type="number" name="due" id="due_input" step=".01" value="0"></th>
                                    <th><input class="form-control" required type="number" name="paid" id="paid_input" step=".01" value="0" readonly="readonly" style="background-color:#566573;"></th>
                                    <th>
                                        <select class="form-select" aria-label="Default select example" name="promotion" id="promotion">
                                            <option value="false">No</option>
                                            <option value="true">Si</option>
                                        </select>
                                    </th>
                                </tr>   
                            </tbody>
                        </table>
                        <h4>Método de pago (solo en caso de facturas)</h4>
                        <select class="form-select" aria-label="Default select example" name="payment_type" id="payment_type">
                            <option value="EF">EFECTIVO</option>
                            <option value="TC">TARJETA C</option>
                            <option value="TD">TARJETA D</option>
                        </select>
                        <br><br>
                        <button type="sumbit" class="btn btn-dark">
                            Cargar movimiento
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>