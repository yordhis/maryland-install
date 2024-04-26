<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo de pago</title>

    <link href="{{ asset('assets/css/styles-recibo.css')}} " rel="stylesheet">

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
    
    
    <div class="caja">
        {{-- <img src="{{ asset('assets/img/recibo_pago.png') }}" class="centrar-img" width="700" alt=""> --}}

        
        <p class="codigo"></p>
        
        

            <ul class="caja-fecha">
                <li>{{ explode('-', $pago->fecha)[2] ?? '' }}</li>
                <li>{{ explode('-', $pago->fecha)[1] ?? '' }}</li>
                <li>{{ explode('-', $pago->fecha)[0] ?? '' }}</li>
            </ul>
 
        {{-- Nombre del Codigo --}}
        <p class="codigo">{{$pago->codigo ?? ''}}</p>
        {{-- Nombre del estudiante --}}
        <p class="nombreEstudiante">{{$pago->estudiante['nombre'] ?? '' }}</p>
        {{-- Nombre del Representante --}}
        <p class="nombreRepresentante">{{$pago->estudiante->representantes[0]['nombre'] ?? '' }}</p>
        
        {{-- Nombre del Horario --}}
        <p class="horario">
            @isset( $pago->horario['horas'])
                <span> {{ $pago->horario['horas'] ?? '' }} </span>
                <span>| Dias: {{ $pago->horario['dias'] ?? '' }}</span>
            @endisset
        </p>

        {{-- Numero de telefono del estudiante --}}
        <p class="telefono">
            {{ '(' . substr($pago->estudiante['telefono'], 0, 4) . ')' . ' ' . substr($pago->estudiante['telefono'], 5, 3) . '-' . substr($pago->estudiante['telefono'], 6, 4) ?? '' }}
        </p>
        {{-- Nombre del Cedula --}}
        <p class="cedula">{{$pago->estudiante['cedula'] ?? '' }}</p>

     
        {{-- Metodo de pago --}}
            <ul class="caja-metodos">
                @isset($metodos)
                    @foreach ($metodos as $metodo)

                        <li class="anio"> 
                            <input 
                            class="" 
                            type="checkbox" 
                            id="{{$metodo['metodo']}}" 
                            name="met_{{$metodo['metodo']}}" 
                            value="{{$metodo['metodo']}}"
                            disabled
                            {{ $metodo['activo'] ? "checked" : "" }}
                            >
                            <label class="form-check-label" style="font-size: 10px;" for="{{$metodo['metodo']}}">{{$metodo['metodo']}}</label>

                        </li>
                            

                    @endforeach
                @endisset
            </ul>
     
        
        
        <ul class="caja-factura">
            {{-- Cantidad --}}
            <li>01</li>
        
            {{-- Monto en divisas --}}
            <li id="montouds">{{ $pago->monto[1] ?? '' }}</li>
    
            {{-- Monto en Bolivares --}}
            <li>{{ $pago->monto[0] ?? '' }}</li>
        </ul>

        <ul class="caja-total">
       
        
            {{-- Total USD --}}
            <li>{{ $pago->monto[1] ?? '' }}</li>
    
            {{--Total BS --}}
            <li>{{ $pago->monto[0] ?? '' }}</li>

        
        </ul>
   

         {{-- Concepto --}}
         <p class="concepto">{{ $pago->concepto ?? '' }}</p>

    </div>


</body>
</html>
