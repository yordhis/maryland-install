<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de pago</title>

    <link href="{{ asset('assets/img/logo-img-circulo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo-img-circulo.png') }}" rel="apple-touch-icon">

    {{-- <link href="{{ asset('assets/css/recibo.css') }} " rel="stylesheet"> --}}
    <link href="{{ asset('assets/css/personalizado.css') }}" rel="stylesheet">
</head>

<body>
    <header class="caja">
        <img src="{{ asset('assets/img/header_recibo.png') }}" alt="cabezera de recibo de pago">
    </header>
    <span class="title text-danger">Control de pago</span>
    <table>
        <thead>
            @foreach ($estudiantes as $key => $estudiante)
                <tr>
                    <td colspan="2" class="bg-gris"> <b>
                        {{ $key + 1 }}
                        Estudiante:
                    </b> </td>
                    <td colspan="4">{{ $estudiante->nombre }} </td>
                    <td colspan="2"><b>C.I:</b> {{ $estudiante->cedulaFormateada }} </td>
                </tr>
            @endforeach

            @if (count($estudiantes[0]->representantes))
                <tr>
                    <td colspan="2" class="bg-gris"> <b>
                        Representante:
                    </b> </td>
                    <td colspan="4">{{ $estudiantes[0]->representantes[0]->representante->nombre }} </td>
                    <td colspan="2"><b>C.I:</b>V-{{ $estudiantes[0]->representantes[0]->representante->cedula }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="bg-gris"><b>Contactos:</b></td>
                    <td colspan="6">
                        {{ $estudiantes[0]->representantes[0]->representante->telefono }} /
                        {{ $estudiantes[0]->telefono }}
                    </td>
                </tr>
            @else
                <tr>
                    <td colspan="2" class="bg-gris"><b>Contactos:</b></td>
                    <td colspan="6">{{ $estudiantes[0]->telefono }} </td>
                </tr>
            @endif

        </thead>
        <thead>
            <tr class="bg-gris">
                <td><b>N° control</b></td>
                <td><b>Fecha</b></td>
                <td><b>Concepto</b></td>
                <td><b>Método</b></td>
                <td><b>Divisas</b></td>
                <td><b>Tasa</b></td>
                <td><b>Bolivares</b></td>
                <td><b>Referencia</b></td>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagos as $pago)
                @foreach ($pago->formas_pagos as $forma)
                    <tr>
                        <td>{{ $pago->codigo }}</td>
                        <td>{{ $pago->fecha }}</td>
                        <td>{{ $pago->concepto }}</td>
                        <td>{{ $forma->metodo }}</td>
                        <td>{{ $forma->monto }}</td>
                        @if ($forma->tasa > 0)
                            <td>{{ $forma->tasa }}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{ $forma->tasa * $forma->monto }}</td>
                        <td>{{ $forma->referencia }}</td>
                    </tr>
                @endforeach
            @endforeach

            
            @if (!$estatusCuotas)
                {{--  Solo mostrar las pendientes --}}
                @foreach ($cuotas as $cuota)
                    @if (!$cuota->estatus)
                        <tr>
                            <td class="text-danger">Pendiente</td>
                            <td class="text-danger">{{ $cuota->fecha }}</td>
                            <td></td>
                            <td class="text-danger">Pendiente</td>
                            <td class="text-danger">{{ $cuota->cuota }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
            @endif

            
        </tbody>
        <tfoot>
            {{-- Total abonado --}}
            <tr>
                <td colspan="3"></td>
                
                <td class="bg-gris">Total abonado</td>
                <td>{{ $inscripciones[0]->abono }}</td>
                <td colspan="3"></td>
                
            </tr>
            @if ($estatusCuotas)
                <tr>
                    <td colspan="8" class="text-title">Todos los pagos completados</td>
                </tr>
            @endif
        </tfoot>
    </table>


</body>

</html>
