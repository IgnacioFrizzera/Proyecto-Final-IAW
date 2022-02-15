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
                        <div class="container-fluid">
                            <li style="font-size: 22px">Pagos con tarjeta de crédito en el mes actual: ${{$current_month_tc_sales}}</li>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="container-fluid" id="soldVsPaidBarChart"></div>
                            </div>
                            <div class="col-6">
                                <div class="container-fluid" id="soldWithPromotionPieChart"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="container-fluid" id="lastYearSalesComparisonBarChart"></div>
                        </div>
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
                            Análisis de movimientos por etiquetas
                        </h3>
                        <div>
                            <h5><strong>Importante:</strong> solo se consideraron los movimientos de Factura (FC) y Factura Cuenta Corriente (FCC)</h5>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="container-fluid" id="brandsBarChart"></div>
                            </div>
                            <div class="col-6">
                                <div class="container-fluid" id="brandsPieChart"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <div class="container-fluid" id="categoriesBarChart"></div>
                            </div>
                            <div class="col-6">
                                <div class="container-fluid" id="categoriesPieChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/charts.js') }}"></script>
