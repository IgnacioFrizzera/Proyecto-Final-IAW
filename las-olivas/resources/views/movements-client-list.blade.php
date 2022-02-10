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
                    <h1 style="text-align:center;">
                        @foreach ($client as $client_data)
                            Movimientos de {{$client_data->name}} {{$client_data->last_name}}
                        @endforeach
                    </h1>
                    <form action="{{route('download-client-movements')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @foreach ($client as $client_data)
                            <input type="hidden" name="client_id" id="client_id" value="{{ $client_data->id }}">
                        @endforeach
                        @if(!isset($message))
                            <button type="sumbit" title="Descargar PDF de movimientos" style="float:right;"> 
                                <i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:48px"></i>
                            </button>
                        @endif
                    </form>
                    <br>
                    <br>
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <hr>    
                        <div class="container-fluid">
                            <form action="{{route('movements-client-list')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @foreach ($client as $client_data)
                                    <input type="hidden" name="client_id" value="{{$client_data->id}}">
                                @endforeach
                                <div class="row justify-content-center">
                                    <div class="col-4">
                                        <span style="font-size: 20px;">Desde:</span>
                                        <input type="date" name="from">
                                    </div>
                                    <div class="col-4">
                                        <span style="font-size: 20px;">Hasta:</span>
                                        <input type="date" name="to" value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>">
                                    </div>
                                    <button type="sumbit" class="btn btn-dark">
                                        Filtrar movimientos
                                    </button>
                                </div>
                            </form>
                        </div>
                        <br>
                        @if(isset($message))
                            <hr>
                            <h2 style="text-align:center;">
                                {{$message}}
                            </h2>
                        @else
                            <table class="table table-bordered table-striped text-left">
                                <thead>
                                    <tr>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Tipo de comprobante</th>
                                        <th scope="col">Debe</th>
                                        <th scope="col">Haber</th>
                                        <th scope="col">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movements as $movement)
                                        <tr>
                                            <td>{{ $movement->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $movement->description }}</td>
                                            <td>{{ $movement->receipt_type }}</td>
                                            <td>{{ $movement->due }}</td>
                                            <td>{{ $movement->paid }}</td>
                                            <td>{{ $movement->balance }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="footer">
                                <?php 
                                    echo $movements->appends(Request::all())->links();
                                ?>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>