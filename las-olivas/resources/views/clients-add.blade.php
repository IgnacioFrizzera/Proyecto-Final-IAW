<!-- Font Awesome Brand Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Carga de clientes') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('clients-add')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container-fluid">
                            <h2>
                                Datos personales del cliente
                            </h2>
                            @if(isset($failedToCreateMessage))
                                <h4 style="color:red; text-decoration:underline">
                                    {{ $failedToCreateMessage }}
                                </h4>
                            @endif
                            <hr>
                            <div class="form-group row">
                                <div class="col-4">
                                    <h4 title="Requerido">Nombre (*)</h4>
                                    <input type="string" class="form-control" name="client_name" id="client_name" placeholder="Nombre" required maxlength="100">
                                    <br>
                                    <h4 title="Requerido">Apellido (*)</h4>
                                    <input type="string" class="form-control" name="client_last_name" id="client_last_name" placeholder="Apellido" required maxlength="100">
                                    <br>
                                    <h4>Cumpleaños</h4>
                                    <input type="date" class="form-control" name="client_birthday" id="client_birthday" min="1920-01-01" maxlength="100">
                                    <br>
                                    <button type="sumbit" class="btn btn-dark">
                                        Cargar cliente
                                    </button>
                                </div>
                                <div class="col-4">
                                    <h4>Email</h4>
                                    <input type="string" class="form-control" name="email" id="email" placeholder="juandoe@gmail.com" maxlength="100">
                                    <br>
                                    <h4>Teléfono</h4>
                                    <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="2222444444" maxlength="20">
                                </div>
                                <div class="col-4">
                                    <h4>Profesión</h4>
                                    <input type="string" class="form-control" name="client_profession" id="client_profession" placeholder="Maestro" maxlength="100">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>