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
                        Cargar Movimiento
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
                                    <select class="form-select" aria-label="Default select example" name="client_id" id="receipt">
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->name }} {{ $client->last_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="col-6">
                                    <h3>No hay clientes en el sistema.</h3>
                                </div>
                            @endif
                        </div>
                        <hr>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Tipo de comprobante</th>
                                    <th scope="col">Debe</th>
                                    <th scope="col">Haber</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th><input type="date" name="date" required value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>"></th>
                                    <th>
                                        <textarea required name="description" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="200"></textarea>
                                    </th>
                                    <th>
                                        <select class="form-select" aria-label="Default select example" name="receipt_type" id="receipt" onchange="disabledOnReceiptType(this.value)">
                                            <option value="FC">FACTURA</option>
                                            <option value="FCC">F. CUENTA CORRIENTE</option>
                                            <option value="EF">EFECTIVO</option>
                                            <option value="TC">TARJETA C</option>
                                            <option value="TD">TARJETA D</option>
                                        </select>
                                    </th>
                                    <th><input required type="number" name="due" id="due_input" step=".01" value="0"></th>
                                    <th><input required type="number" name="paid" id="paid_input" step=".01" value="0" readonly="readonly" style="background-color:#566573;"></th>
                                </tr>   
                            </tbody>
                        </table>
                        <button type="sumbit" class="btn btn-dark">
                            Cargar movimiento
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>