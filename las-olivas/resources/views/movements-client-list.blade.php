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
                    <br>
                    @if(isset($message))
                        <hr>
                        <h2 style="text-align:center;">
                            {{$message}}
                        </h2>
                    @else
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <hr>    
                            <div class="container-fluid">
                                <form action="{{route('movements-client-list')}}" method="GET" enctype="multipart/form-data">
                                    @foreach ($client as $client_data)
                                        <input type="hidden" name="client_id" value="{{$client_data->id}}">
                                    @endforeach
                                    <div class="row justify-content-center">
                                        <div class="col-4">
                                            <span style="font-size: 20px;">Desde:</span>
                                            <input type="date" name="from" required>
                                        </div>
                                        <div class="col-4">
                                            <span style="font-size: 20px;">Hasta:</span>
                                            <input type="date" name="to" required>
                                        </div>
                                        <button type="sumbit" class="btn btn-dark">
                                            Filtrar movimientos
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <table class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Tipo de recibo</th>
                                            <th scope="col">Debe</th>
                                            <th scope="col">Haber</th>
                                            <th scope="col">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($movements as $movement)
                                            <tr>
                                                <td>{{$movement->created_at}}</td>
                                                <td>{{$movement->description}}</td>
                                                <td>{{$movement->receipt_type}}</td>
                                                <td>{{$movement->due}}</td>
                                                <td>{{$movement->paid}}</td>
                                                <td>{{$movement->balance}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                            <div class="footer">
                                <?php 
                                    echo $movements->appends(Request::all())->links();
                                ?>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>