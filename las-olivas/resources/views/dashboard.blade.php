<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
@include ('jsvars')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container-fluid">
                        <h3>
                            Análisis de saldos y clientes del sistema
                        </h3>
                        <div class="container-fluid">
                            <li style="font-size: 22px">Clientes registrados en el sistema: {{$total_clients}}</li>
                            <li style="font-size: 22px">Saldos acumulados: ${{$total_balance}}</li>
                        </div>
                    </div>
                    <hr>
                    <div class="container-fluid">
                        <h3>
                            Análisis de ventas
                        </h3>
                    </div>
                    <hr>
                    <div class="container-fluid">
                        <h3>
                            Análisis de movimientos
                        </h3>
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="container-fluid" id="movementsBarChart"></div>
                            </div>
                            <div class="col-6">
                                <div class="container-fluid" id="movementsPieChart"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="container-fluid">
                    <div class="container-fluid">
                        <h3>
                            Filtros por etiquetas
                        </h3>
                        <h4>Insertar gráfico</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/charts.js') }}"></script>
