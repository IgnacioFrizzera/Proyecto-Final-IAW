<!-- Font Awesome Brand Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administración de clientes') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 style="text-align:center;">Listado de clientes</h1><br>
                    @if(isset($message))
                        <div class="container" style="text-align:center;">
                            {{ $message }}
                        </div>
                    @endif
                    @if(isset($deleteMessage))
                            <div class="container" style="text-align:center;">
                                {{ $deleteMessage }}
                            </div>
                    @endif
                    <div class="container" style="text-align:center;">
                        <form action="{{route('clients-search')}}" method="GET" enctype="multipart/form-data">
                        @csrf
                            <input type="text" name="search">
                            <button type="sumbit">Buscar</button>
                        </form>
                    </div><br>
                    @if(isset($searchMessage))
                            <div class="container" style="text-align:center;">
                                {{ $searchMessage }}
                            </div>
                    @endif
                    @if(isset($clients))
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Numero de teléfono</th>
                                        <th scope="col">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                    <tr>
                                        <form action="{{route('clients-update')}}" method="GET" enctype="multipart/form-data">
                                        @csrf
                                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                                            <input type="hidden" name="client_name" value="{{ $client->name }}"><th>{{ $client->name }}</th>
                                            <input type="hidden" name="client_last_name" value="{{ $client->last_name }}"><td> {{ $client->last_name }} </td>
                                            <input type="hidden" name="client_email" value="{{ $client->email }}"><td> {{ $client->email }} </td>
                                            <input type="hidden" name="client_phone_number" value="{{ $client->phone_number }}"><td> {{ $client->phone_number }} </td>
                                            <td> $ Hacer </td>
                                            <td><button type="sumbit" name="action" value="delete"><i class="fa fa-minus-circle" style="font-size:24px"></i></button></td>
                                            <td><button type="sumbit" name="action" value="update"><i class="fa fa-pencil" aria-hidden="true" style="font-size:24px"></i></button></td>
                                        </form>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>