<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ventas mensuales') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2>
                        Cargar ventas mensuales
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
                                        <select class="form-select" aria-label="Default select example" name="month" id="month">
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input required type="number" min="2010" max="<?php echo date('Y');?>" name="year" value="2010">
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
                                    <td><input class="form-control" required type="number" min="0" name="fc_sales" id="fc_sales" step=".01" value="0"></td>
                                    <td><input class="form-control" required type="number" min="0" name="fcc_sales" id="fcc_sales" step=".01" value="0"></td>
                                    <td><input class="form-control" required type="number" min="0" name="ef_sales" id="ef_sales" step=".01" value="0"></td>
                                    <td><input class="form-control" required type="number" min="0" name="tc_sales" id="tc_sales" step=".01" value="0"></td>
                                    <td><input class="form-control" required type="number" min="0" name="td_sales" id="td_sales" step=".01" value="0"></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="sumbit" class="btn btn-dark">
                            Cargar ventas
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>