<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Actualización de info. de clientes') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(isset($clientData))
                        <form action="{{route('clients-update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="container-fluid">
                                <h2>
                                    Datos personales del cliente
                                </h2>
                                @if(isset($failedToUpdate))
                                    <h4 style="color:red; text-decoration:underline">
                                        {{ $failedToUpdate }}
                                    </h4>
                                @endif
                                <hr>
                                <div class="form-group row">
                                    @foreach ($clientData as $client)
                                    <input type="hidden" name="id" name="id" value="{{ $client->id }}">
                                    <div class="col-4">
                                        <h4 title="Requerido">Nombre (*)</h4>
                                        <input type="string" class="form-control" name="client_name" id="client_name" value="{{ $client->name }}" required maxlength="100">
                                        <br>
                                        <h4 title="Requerido">Apellido (*)</h4>
                                        <input type="tel" class="form-control" name="client_last_name" id="client_last_name" value="{{ $client->last_name }}" required maxlength="100">
                                        <br>
                                        <h4>Cumpleaños (*)</h4>
                                        <input type="date" class="form-control" name="client_birthday" id="client_birthday" value="{{ $client->birthday }}" min="1920-01-01" maxlength="100">
                                        <br>
                                        <button type="sumbit" class="btn btn-dark">
                                            Actualizar datos
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <h4>Email</h4>
                                        <input type="string" class="form-control" name="email" id="email" value="{{ $client->email }}" maxlength="100">
                                        <br>
                                        <h4>Teléfono</h4>
                                        <input type="tel" class="form-control" name="phone_number" id="phone_number" value="{{ $client->phone_number }}" maxlength="20">
                                        <br>
                                        <h4>Dirección</h4>
                                        <input type="string" class="form-control" name="client_address" id="client_address" value="{{ $client->address }}" maxlength="100">
                                    </div>
                                    <div class="col-4">
                                        <h4>Profesión</h4>
                                        <input type="string" class="form-control" name="client_profession" id="client_profession" value="{{ $client->profession }}" maxlength="100">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </form>
                    @else
                        <h1>No user data</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>