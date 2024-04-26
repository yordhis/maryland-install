<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de pago</title>

    <link href="{{ asset('assets/css/styles-recibo.css') }} " rel="stylesheet">

    {{-- <style>
        

        body{
            font-family: 'Times New Roman', Times, serif;
            margin: 0%;
            padding: 0%;
        }

    

        .caja{
            position: relative;
            display: inline-block;
            text-align: center;
            padding: 0%;
        }
        
       
        .nombreEstudiante{
            position: absolute;
            margin-top: -315px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 180px;
        }
        
        .nombreRepresentante{
            position: absolute;
            margin-top: -285px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 130px;
        }  
         
        .codigo{
            position: absolute;
            color:#D90000;
            font-size: 35px;
            margin-top: -370px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 530px;
        }
         
        .cedula{
            position: absolute;
            font-size: 20px;
            margin-top: -250px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 220px;
        } 
        .telefono{
            position: absolute;
            font-size: 15px;
            margin-top: -247px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 30px;
        } 

        .horario{
            position: absolute;
            font-size: 11px;
            text-align: left;
         
            margin-top: -285px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 450px;
        }
        
        .caja-fecha{
            position: absolute;
            margin-top: -435px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 500px;
        }
        .caja-metodos{
            position: absolute;
            font-size: 9px;
            margin-top: -250px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 380px;
        }
        
        .caja-factura{
            position: absolute;
            margin-top: -185px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 0px;
        }

        .caja-total{
            position: absolute;
            margin-top: -60px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 470px;
        }

        .concepto{
            
            margin-top: -185px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: -160px;
       }
       
        li {
            display: inline;
            margin-top: 0px;
            margin-bottom: 0px;
            margin-right: 10px;
            margin-left: 10px;
        }

        .caja-metodos > li{
            display: inline;
            margin-top: 0px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 0px;
        }

        .caja-factura > li{
            display: inline;
            font-size: 15px;
            margin-top: 0px;
            margin-bottom: 0px;
            margin-right: 60px;
            margin-left: 0px;
        }
        
        .caja-total > li{
            display: inline;
            font-size: 15px;
            margin-top: 0px;
            margin-bottom: 0px;
            margin-right: 60px;
            margin-left: 0px;
        }

       
        #montouds{
            margin-left: 395px;
        }

        

    </style> --}}


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
