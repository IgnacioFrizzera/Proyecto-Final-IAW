<!-- Font Awesome Brand Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <form action="{{route('movements-add')}}" method="POST" enctype="multipart/form-data"> 
                    @csrf
                        <div class="row">
                            <div class="col-1">
                                <h3>Cliente: </h3>
                            </div>  
                            <div class="col-3">
                                @if(isset($clients))
                                    <input class="form-control" list="clients-list" name="selected_client" placeholder="Busca un cliente..." required>
                                    <datalist id="clients-list">
                                        @foreach($clients as $client)
                                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                                            <option value="{{ $client->name }} {{ $client->last_name }}">
                                        @endforeach
                                    </datalist>
                                @else
                                    <h5>No hay clientes en el sistema.</h5>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Tipo de recibo</th>
                                    <th scope="col">Debe</th>
                                    <th scope="col">Haber</th>
                                    <th scope="col">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                        <th>
                                            <textarea required name="description" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' maxlength="200"></textarea>
                                        </th>
                                        <th>
                                            <select class="form-select" aria-label="Default select example" name="receipt_type">
                                                <option value="FACTURA">FACTURA</option>
                                                <option value="EFECTIVO">EFECTIVO</option>
                                                <option value="TARJETA C">TARJETA C</option>
                                                <option value="TARJETA D">TARJETA D</option>
                                            </select>
                                        </th>
                                        <th><input required type="number" name="due" step=".01" value="0"></th>
                                        <th><input required type="number" name="paid" step=".01" value="0"></th>
                                        <th><input required type="number" name="balance" step=".01" value="0"></th>
                                    </form>
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