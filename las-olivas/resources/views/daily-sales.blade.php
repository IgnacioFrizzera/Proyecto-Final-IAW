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
                    <h2 style="text-align:center;">
                        Venta diaria
                    </h2>
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
                    @if(isset($movements))
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
                                    @foreach ($daily_sales as $sale_type)
                                        <th>{{$sale_type}}</th>
                                    @endforeach
                                </tr>
                            </tbody>
                            </thead>
                        </table>
                        <hr>
                        <h2 style="text-align:center;">Detalle de movimientos</h2>
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Movimiento</th>
                                    <th scope="col">Debe</th>
                                    <th scope="col">Haber</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movements as $movement)
                                    <tr>
                                        <th>{{$movement->description}}</th>
                                        <th>{{$movement->due}}</th>
                                        <th>{{$movement->paid}}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h3 style="text-align: center;">
                            No hubo ventas en el día actual
                        </h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>