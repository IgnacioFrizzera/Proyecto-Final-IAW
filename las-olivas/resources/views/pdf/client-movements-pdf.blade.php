<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <img src="{{ public_path().'/static/las-olivas-logo.png' }}" width="75" height="75">
        <p style="font-size: 32px"> {{ $client_data->name }} {{ $client_data->last_name }} </p>
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
                    <th scope="col-1">Fecha</th>
                    <th scope="col-3">Descripción</th>
                    <th scope="col-1">Tipo de recibo</th>
                    <th scope="col-2">Debe</th>
                    <th scope="col-2">Haber</th>
                    <th scope="col-2">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($client_movements as $movement)
                    <tr>
                        <td> {{ $movement->created_at->format('d/m/Y') }} </td>
                        <td> {{ $movement->description }} </td>
                        <td> {{ $movement->receipt_type }} </td>
                        <td> {{ $movement->due }} </td>
                        <td> {{ $movement->paid }} </td>
                        <td> {{ $movement->balance }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>