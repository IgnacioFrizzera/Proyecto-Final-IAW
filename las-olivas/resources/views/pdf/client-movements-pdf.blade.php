<html>
    <head>
    </head>
    <body>
        <img src="{{ public_path().'/static/las-olivas-logo.png' }}" width="75" height="75">
        <h2> {{ $client_data->name }} {{ $client_data->last_name }} </h2>
        <hr>
        @if(isset($client_data->address))
            <li> Dirección: {{ $client_data->address }} </li>            
        @endif
        @if(isset($client_data->phone_number))
            <li> Teléfono: {{ $client_data->phone_number }} </li>            
        @endif
        <hr>
        <table class="table">
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
                @foreach ($client_movements as $movement)
                    <tr>
                        <td> {{$movement->created_at->format('d/m/Y')}} </td>
                        <td> {{$movement->description}} </td>
                        <td> {{$movement->receipt_type}} </td>
                        <td> {{$movement->due}} </td>
                        <td> {{$movement->paid}} </td>
                        <td> {{$movement->balance}} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>