<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <img src="{{ public_path().'/static/las-olivas-logo.png' }}" width="75" height="75">
        <p style="font-size: 32px"> {{ $client_data->name }} {{ $client_data->last_name }} </p>
        <hr>
        <div class="container-fluid">
            @if(isset($client_data->address))
                <li> Dirección: {{ $client_data->address }} </li>            
            @endif
            @if(isset($client_data->phone_number))
                <li> Teléfono: {{ $client_data->phone_number }} </li>            
            @endif
        </div>
        <hr>
        <div class="container-fluid">
            @if(isset($from))
                <li> Mostrando movimientos desde: {{ $from }} hasta: {{ $to }} </li>
            @endif
        </div>
        <hr>
        <table class="table table-bordered text-left">
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
                <tr>
                    <td></td>
                    <td style="font-size: 20px">Saldo anterior</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-size: 20px">
                        @if(isset($last_month_balance))
                            ${{ $last_month_balance }} 
                        @endif
                    </td>
                </tr>
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
                <tr>
                    <td></td>
                    <td style="font-size: 20px">Saldo</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-size: 20px">
                        @if(isset($current_balance))
                            ${{ $current_balance }} 
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>