<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actualización de datos de venta mensual') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(isset($message))
                        <div class="container-fluid">
                            <h2>
                                {{$message}}
                            </h2>
                        </div>
                    @else
                        @if(isset($sale))
                            <div class="container-fluid">
                                <h2>
                                    Modificar venta
                                </h2>
                                @if(isset($errorMessage))
                                    <h4 style="color:red; text-decoration:underline">
                                        {{ $errorMessage }}
                                    </h4>
                                @endif
                                <hr>
                                <div class="container-fluid">
                                    <form action="{{route('monthly-sales-update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @foreach ($sale as $sale_data)
                                            <input type="hidden" name="id" value="{{ $sale_data->id }}">
                                            <div class="form-group row">
                                                <div class="col-6">
                                                    <h6>Mes actual</h6>
                                                    <input type="string" class="form-control" name="old_month" id="old_month" value="{{ $sale_data->month }}" readonly>
                                                    <br>
                                                    <h6>Año actual</h6>
                                                    <input type="string" class="form-control" name="old_year" id="old_year" value="{{ $sale_data->year }}" readonly>
                                                    <br>
                                                    <h6>Venta FC actual</h6>
                                                    <input type="string" class="form-control" name="old_fc" id="old_fc" value="{{ $sale_data->fc }}" readonly>
                                                    <br>
                                                    <h6>Venta FCC actual</h6>
                                                    <input type="string" class="form-control" name="old_fcc" id="old_fcc" value="{{ $sale_data->fcc }}" readonly>
                                                    <br>
                                                    <h6>Venta EF actual</h6>
                                                    <input type="string" class="form-control" name="old_ef" id="old_ef" value="{{ $sale_data->ef }}" readonly>
                                                    <br>
                                                    <h6>Venta TC actual</h6>
                                                    <input type="string" class="form-control" name="old_tc" id="old_tc" value="{{ $sale_data->tc }}" readonly>
                                                    <br>
                                                    <h6>Venta TD actual</h6>
                                                    <input type="string" class="form-control" name="old_td" id="old_td" value="{{ $sale_data->td }}" readonly>
                                                    <br>
                                                    <button type="sumbit" class="btn btn-dark">
                                                        Actualizar datos
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <h6>Mes nuevo</h6>
                                                    <input type="number" class="form-control" name="new_month" id="new_month" min="1" max="12" value="{{ $sale_data->month }}" required>
                                                    <br>
                                                    <h6>Año nuevo</h6>
                                                    <input type="number" class="form-control" name="new_year" id="new_year" min="2010" max="<?php echo date('Y');?>" value="{{ $sale_data->year }}" required>
                                                    <br>
                                                    <h6>Venta FC nuevo</h6>
                                                    <input class="form-control" required type="number" min="0" name="fc_sales" id="fc_sales" step=".01" value="{{ $sale_data->fc }}" required>
                                                    <br>
                                                    <h6>Venta FCC nuevo</h6>
                                                    <input class="form-control" required type="number" min="0" name="fcc_sales" id="fcc_sales" step=".01" value="{{ $sale_data->fcc }}" required>
                                                    <br>
                                                    <h6>Venta EF nuevo</h6>
                                                    <input class="form-control" required type="number" min="0" name="ef_sales" id="ef_sales" step=".01" value="{{ $sale_data->ef }}" required>
                                                    <br>
                                                    <h6>Venta TC nuevo</h6>
                                                    <input class="form-control" required type="number" min="0" name="tc_sales" id="tc_sales" step=".01" value="{{ $sale_data->tc }}" required>
                                                    <br>
                                                    <h6>Venta TD nuevo</h6>
                                                    <input class="form-control" required type="number" min="0" name="td_sales" id="td_sales" step=".01" value="{{ $sale_data->td }}" required>
                                                    <br>
                                                </div>
                                            </div>
                                        @endforeach
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>