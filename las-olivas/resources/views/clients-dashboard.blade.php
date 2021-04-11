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
                    @if(isset($message))
                        <div>
                            {{ $message }}
                        </div>
                    @endif
                    @if(isset($clients))
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <h1 style="text-align:center;">Listado de clientes</h1>
                        <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Numero de teléfono</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                    <tr>
                                        <th> {{ $client->name }} </th>
                                        <td> {{ $client->last_name }} </td>
                                        <td> {{ $client->email }} </td>
                                        <td> {{ $client->phone_number }} </td>
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