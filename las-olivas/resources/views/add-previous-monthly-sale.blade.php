<!-- Font Awesome Brand Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ventas históricas mensuales') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2>
                        Cargar ventas históricas mensuales
                    </h2>
                    <hr>
                    @if(isset($invalidDate))
                        <h4 style="color:red; text-decoration:underline">
                            {{$invalidDate}}
                        </h4>
                        <hr>
                    @endif
                    @if(isset($message))
                        <h4>
                            {{$message}}
                        </h4>
                        <hr>
                    @endif
                    <form action="{{route('monthly-sales-add')}}" method="POST" enctype="multipart/form-data"> 
                    @csrf
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Mes</th>
                                    <th scope="col">Año</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="number" class="form-control" name="month" id="month" min="1" max="12" value="1" required>
                                    </td>
                                    <td>
                                        <input class="form-control" required type="number" min="2010" max="<?php echo date('Y');?>" name="year" value="2010">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Factura</th>
                                    <th scope="col">Factura CC</th>
                                    <th scope="col">Efectivo</th>
                                    <th scope="col">Tarjeta C</th>
                                    <th scope="col">Tarjeta D</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input class="form-control" required type="number" min="0" name="fc_sales" id="fc_sales" step=".01"></td>
                                    <td><input class="form-control" required type="number" min="0" name="fcc_sales" id="fcc_sales" step=".01"></td>
                                    <td><input class="form-control" required type="number" min="0" name="ef_sales" id="ef_sales" step=".01"></td>
                                    <td><input class="form-control" required type="number" min="0" name="tc_sales" id="tc_sales" step=".01"></td>
                                    <td><input class="form-control" required type="number" min="0" name="td_sales" id="td_sales" step=".01"></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="sumbit" class="btn btn-dark">
                            Cargar ventas
                        </button>
                    </form>
                    @if(isset($sales))
                        <hr>
                        <h2>
                            Ventas mensuales cargadas en el sistema
                        </h2>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Mes</th>
                                    <th scope="col">Año</th>
                                    <th scope="col">Factura</th>
                                    <th scope="col">Factura CC</th>
                                    <th scope="col">Efectivo</th>
                                    <th scope="col">Tarjeta C</th>
                                    <th scope="col">Tarjeta D</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->month }}</td>
                                        <td>{{ $sale->year }}</td>
                                        <td>{{ $sale->fc }}</td>
                                        <td>{{ $sale->fcc }}</td>
                                        <td>{{ $sale->ef }}</td>
                                        <td>{{ $sale->tc }}</td>
                                        <td>{{ $sale->td }}</td>
                                        <form action="{{route('monthly-sales-delete')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $sale->id }}">
                                            <td><button type="sumbit" title="Eliminar venta" onclick="return confirm('¿Estas seguro que deseas eliminar la venta mensual?')"><i class="fa fa-minus-circle" aria-hidden="true" style="font-size:24px"></i></button></td>
                                        </form>
                                        <form action="{{route('monthly-sales-update-index')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $sale->id }}">
                                            <td><button type="sumbit" title="Modificar datos de la venta"><i class="fa fa-pencil" aria-hidden="true" style="font-size:24px"></i></button></td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>