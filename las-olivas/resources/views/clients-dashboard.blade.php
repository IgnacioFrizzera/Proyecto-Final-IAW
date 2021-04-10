<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administración de clientes') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(isset($message))
                    <div>
                        {{ $message }}
                    </div>
                @endif
                @if(isset($clients))
                    <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
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
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
