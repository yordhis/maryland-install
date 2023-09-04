<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planilla de inscripción </title>
    <link href="assets/css/fuente.css">

    {{-- SEO --}}
    <meta content="" name="description">
    <meta content="" name="keywords">
    <base href="http://academiamaryland.com/" target="objetivo">
    <!-- Favicons -->
    <link href="assets/img/logo-img-circulo.png" rel="icon">
    <link href="assets/img/logo-img-circulo.png" rel="apple-touch-icon">

   

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/personalizado.css" rel="stylesheet">

    <style>
        body{
            background-color: white;
            padding: 0px;
            margin: 0px;
        }
        img{
            position: absolute;
            margin-left: -10px;
            width: 700px;
            background-position: 0%;
        }
        .caja{
            position: relative;
            display: inline-block;
            text-align: center;
        }
        #codigo{
            position: absolute;
            color:#D90000;
            font-size: 25px;
            margin-top: 21px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 585px;
        }
        #fecha{
            position: absolute;
            color:#000000;
            font-size: 18px;
            margin-top: 65px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 550px;
        }

        /* START estilos Estudiante */
        #nombre{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
         
            width:210px;
            font-size: 12px;
            margin-top: 180px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 65px;
        }
        #cedula{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 180px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 475px;
        }
        #edad{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 180px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 645px;
        }
        #nacimiento{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 210px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 100px;
        }
        #telefono{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 210px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 240px;
        }
        #correo{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 210px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 440px;
        }
        
        #dificultades{
            position: absolute;
            color:#000000;
            /* background-color: #d9000026; */
           
            width: 350px;
            font-size: 12px;
            margin-top: 233px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 75px;
        }
        #dificultades > li{
            display: inline; 
        }
        #direccion{
            position: absolute;
            color:#000000;
            /* background-color: #d9000026; */
           text-align: left;
            width: 350px;
            font-size: 12px;
            margin-top: 260px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 145px;
        }
        /* END estilos Estudiante */


        /* START Estilos Representante */
        #rep_nombre{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
         
            width:210px;
            font-size: 12px;
            margin-top: 305px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 65px;
        }
        #rep_cedula{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 305px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 475px;
        }
        #rep_edad{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 305px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 645px;
        }
        #rep_telefono{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 335px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 75px;
        }
        #rep_correo{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 335px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 440px;
        }
        #rep_ocupacion{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:350px;
            font-size: 12px;
            margin-top: 360px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 85px;
        }
        #rep_direccion{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:350px;
            font-size: 12px;
            margin-top: 385px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 145px;
        }/* END Estilos Representante */

        /* START Estilos Plan de Estudio */
        #nivel{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:100px;
            font-size: 12px;
            /* background-color: #d900002c; */
            margin-top: 435px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 95px;
        }
        #grupo{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 430px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 330px;
        }
        #fecha_init{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 438px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 486px;
        }
        #fecha_end{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: start;
            width:auto;
            font-size: 12px;
            margin-top: 438px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 595px;
        }
        #horario{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            display: inline;
            width:450px;
            font-size: 12px;
            /* background-color: #d900002c; */
            margin-top: 460px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 65px;
        }

        #plan_nombre{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:100px;
            font-size: 12px;
            /* background-color: #d900002c; */
            margin-top: 510px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 95px;
        }
        #plan_descripcion{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:250px;
            font-size: 12px;
            margin-top: 501px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 350px;
        }
        #nivel_precio{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:auto;
            font-size: 12px;
            margin-top: 501px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 625px;
        }
        
        #cuotas{
            position: absolute;
            color:#000000;
            /* background-color: #d9000026; */
            text-align: left;
            width: 550px;
            font-size: 12px;
            margin-top: 533px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 15px;
        }
        #cuotas > li{
            display: inline; 
        }
        /* END Estilos Plan de Estudio */

        /* START Datos Extras */
        #si_promo{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:auto;
            font-size: 16px;
            margin-top: 557px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 107px;
        }
        #no_promo{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:auto;
            font-size: 16px;
            margin-top: 557px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 147px;
        }
        #explique{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:450px;
            font-size: 12px;
            margin-top: 560px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 220px;
        }

        #si_material{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:auto;
            font-size: 16px;
            margin-top: 585px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 145px;
        }

        #no_material{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:auto;
            font-size: 16px;
            margin-top: 585px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 185px;
        }

        #se_entero{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:450px;
            font-size: 12px;
            margin-top: 585px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 360px;
        }

        #observacion{
            position: absolute;
            color:#000000;
            /* background-color: #D90000; */
            text-align: left;
            width:550px;
            font-size: 12px;
            margin-top: 615px;
            margin-bottom: 0px;
            margin-right: 0px;
            margin-left: 85px;
        }
        /* END Datos Extras */
        </style>

</head>

<body>
    <div class="caja">
        <img src="assets/img/planilla.png" alt="planilla pdf" >
        
        <span id="codigo"> {{ $inscripcione->codigo ?? '' }} </span>
        <span id="fecha"> {{ $inscripcione->fecha ?? '' }} </span>
        <span id="nombre"> {{ $estudiante->nombre ?? '' }} </span>
        <span id="cedula"> {{ $estudiante->nacionalidad ?? '' }}-{{ $estudiante->cedulaFormateada ?? '' }} </span>
        <span id="edad"> {{ $estudiante->edad ?? '' }} </span>
        <span id="nacimiento"> {{ $estudiante->nacimiento ?? '' }} </span>
        <span id="telefono"> {{ $estudiante->telefono ?? '' }} </span>
        <span id="correo"> {{ $estudiante->correo ?? '' }}</span>
        <ul id="dificultades">
            @foreach ($estudiante->dificultades as $dificultad)
                <li class="lista">
                    <input type="checkbox" disabled {{ $dificultad->estatus ? 'checked' : '' }}>
                    <label for="dif"> {{ $dificultad->dificultad }} </label>
                </li>
            @endforeach
        </ul>
        <span id="direccion"> {{ $estudiante->direccion ?? '' }}</span>

        <!-- START Datos Representante -->
        <span id="rep_nombre"> {{ count($estudiante->representantes) ? $estudiante->representantes[0]->nombre : ''}} </span>
        <span id="rep_cedula"> {{ count($estudiante->representantes) ? number_format($estudiante->representantes[0]->cedula, 0, ',', '.') : ''}}
        </span>
        <span id="rep_edad"> {{ count($estudiante->representantes) ? $estudiante->representantes[0]->edad : '' }} </span>
        <span id="rep_telefono"> {{ count($estudiante->representantes) ? $estudiante->representantes[0]->telefono : '' }} </span>
        <span id="rep_correo"> {{ count($estudiante->representantes) ? $estudiante->representantes[0]->correo : '' }}</span>
        <span id="rep_ocupacion"> {{ count($estudiante->representantes) ? $estudiante->representantes[0]->ocupacion : '' }} </span>
        <span id="rep_direccion"> {{ count($estudiante->representantes) ? $estudiante->representantes[0]->direccion : '' }} </span>
        <!-- End Datos Representante -->

        <!-- START Plan de Estudio -->
        <span id="nivel"> 
            {{ $inscripcione->grupo['nivel']->nombre ?? '' }} 
             
        </span>
        <span id="grupo">{{ $inscripcione->grupo['nombre'] ?? '' }} </span>
        <span id="fecha_init"> {{ $inscripcione->grupo['fecha_inicio'] ?? '' }} </span>
        <span id="fecha_end"> {{ $inscripcione->grupo['fecha_fin'] ?? '' }} </span>
        <span id="horario">
            {{ $inscripcione->grupo['hora_inicio'] . ' - ' . $inscripcione->grupo['hora_fin'] ?? ''}}
            <b>Dias:</b> {{ $inscripcione->grupo['dias'] ?? '' }}
            <b>Libro:</b> {{ $inscripcione->grupo['nivel']->libro ?? '' }}
        </span>
        <!-- END  Plan de Estudio -->

        <!-- START  Plan de Pago -->
        <span id="plan_nombre"> {{ $inscripcione->plan->nombre ?? '' }} </span>
        <span id="plan_descripcion">{{ $inscripcione->plan->descripcion ?? '' }} <br>
            Cantidad de cuotas: {{ $inscripcione->plan->cantidad_cuotas ?? '' }}
        </span>
        <span id="nivel_precio"> Ref: <br>{{ $inscripcione->grupo['nivel']->precio ?? '' }} </span>
        <ul id="cuotas">
            @foreach ($inscripcione->cuotas as $cuota)
                <li class="d-inline ms-2">
                    <input type="checkbox" disabled {{ $cuota->estatus ? 'checked' : '' }}>
                    <label for="dif"> Ref: {{ $cuota->cuota }} | {{ $cuota->fecha }}
                    </label>
                </li>
            @endforeach
        </ul>
        <!-- END  Plan de Pago -->

        <!-- START Datos Extras -->
        @php

            $extras = explode(",", $inscripcione->extras);
        @endphp
        @if ($extras[0] == 'si')
            <i id="si_promo">X</i>
        @endif
        @if ($extras[0] == 'no')
            <i id="no_promo">X</i>
        @endif

        <span id="explique">{{ empty($extras[1]) ? '' : $extras[1] }}</span>
        
        @if ($extras[2] == 'si')
        <i id="si_material">X</i>
        @endif
        @if ($extras[2] == 'no')
        <i id="no_material">X</i>
        @endif
        <span id="se_entero">{{  empty($extras[3]) ? '' : $extras[3] }}</span>
        <span id="observacion">{{ empty($extras[4]) ? '' : $extras[4] }}</span>
        <!-- END Datos Extras -->
    </div>

     {{-- 

    
     --}}


</body>

</html>
