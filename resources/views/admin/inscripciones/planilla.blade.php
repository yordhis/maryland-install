@extends('layouts.app')

@section('title', 'Planilla de inscripción')

@section('content')
    @isset($respuesta['activo'])
        @include('partials.alert')
    @endisset
    <div id="alert"></div>

    <section class="section">
        <div class="row">

            <div class="col-sm-12">
                <h2> Planilla de inscripción <span class="fs-6 text-muted">(Pre-visualización)</span> </h2>
            </div>



            <div class="col-lg-12">
                <div class="card p-0 m-0">

                    <div class="card-head ">
                        <div class="row">

                            <div class="position-relative ">
                                <img src="{{ asset('assets/img/Planilla-head-custom.png') }}" class="img-fluid " style="" alt="">
                                <div class="position-absolute top-0 end-0">

                                    <div class="mt-3 mx-5">
                                        <!-- Codigo de inscripcion-->
                                        <div class="card border border-1 shadow-none">
                                            <p class="text-inline p-2 m-0">
                                                <b class="text-danger fs-5">N° Recibo: </b>
                                                <span class="text-danger fs-4"> {{ $inscripcione->codigo }} </span>
                                            </p>
                                        </div>
                                        <!-- Fecha de inscripcion-->
                                        <div class="card border border-1 shadow-none">
                                            <p class="text-inline p-2 m-0">
                                                <b class="text-danger">Fecha de Inscripción: </b><br>
                                                <span id="fecha"> {{ $inscripcione->fecha }} </span>
                                            </p>
                                        </div>
        
        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pe-2 ps-2 m-0">

                        <h1 class="text-center">Planilla de Inscripción</h1>

                        <table class="table table-bordered border border-dark">
                            <thead>
                                <tr>
                                    <th class="fs-4 text-center" colspan="4">Datos del Estudiante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Start Datos de estudiante -->
                                <tr class="text-start">
                                    <td colspan="4">
                                        <b>Nombre y Apellido:</b>
                                        <span> {{ $estudiante->nombre ?? '' }} </span>
                                    </td>
                                    
                                </tr>
                                <tr class="text-start">
                                    <td colspan="2">
                                        <b>Cédula:</b>
                                        <span> {{ $estudiante->cedulaFormateada }} </span>
                                    </td>
                                    <td colspan="2">
                                        <b>Edad:</b>
                                        <span> {{ $estudiante->edad }} </span>
                                    </td>
                                    
                                </tr>

                                <tr class="text-start">
                                    <td>
                                        <b>F. Nacimiento:</b>
                                        <span> {{ $estudiante->nacimiento }} </span>
                                    </td>
                                    <td>
                                        <b>Teléfono:</b>
                                        <span> {{ $estudiante->telefono }} </span>
                                    </td>
                                    <td colspan="2">
                                        <b>Correo:</b>
                                        <span> {{ $estudiante->correo }}</span>
                                    </td>
                                </tr>

                                <tr class="text-start ">
                                    <td colspan="4">
                                        <ul class="nav-link">
                                            <b>Dificultades de Aprendizaje:</b>
                                            @foreach ($estudiante->dificultades as $dificultad)
                                                <li class="d-inline ms-2">
                                                    <input type="checkbox" disabled
                                                        {{ $dificultad->estatus ? 'checked' : '' }}>
                                                    <label for="dif"> {{ $dificultad->dificultad }} </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>

                                <tr class="text-start ">
                                    <td colspan="4">
                                        <b>Dirección de habitación:</b>
                                        <span> {{ $estudiante->direccion }}</span>
                                    </td>
                                </tr>
                                <!-- End Datos de estudiante -->
                            </tbody>
                            @if ($estudiante->representantes[0])
                            <thead>
                                <tr>
                                    <th class="fs-4 text-center" colspan="4">Datos del Representante</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr class="text-start">
                                        <td colspan="2">
                                            <b>Nombre y Apellido: {{ count($estudiante->representantes) }}</b>
                                            <span> {{ $estudiante->representantes[0]->nombre ?? '' }} </span>
                                        </td>
                                        <td>
                                            <b>Cédula:</b>
                                            <span> {{ number_format($estudiante->representantes[0]->cedula, 0, ',', '.') ?? ''}} </span>
                                        </td>
                                        <td>
                                            <b>Edad:</b>
                                            <span> {{ $estudiante->representantes[0]->edad ?? '' }} </span>
                                        </td>
                                    </tr>

                                    <tr class="text-start">
                                        <td>
                                            <b>Teléfono:</b>
                                            <span> {{  $estudiante->representantes[0]->telefono ?? '' }} </span>
                                        </td>
                                        <td colspan="3">
                                            <b>Correo:</b>
                                            <span> {{  $estudiante->representantes[0]->correo ?? '' }}</span>
                                        </td>
                                    </tr>
                                    
                                    <tr class="text-start">
                                        <td colspan="4">
                                            <b>Ocupación:</b>
                                            <span> {{  $estudiante->representantes[0]->ocupacion ?? '' }} </span>
                                        </td>
                                    </tr>

                                    <tr class="text-start">
                                        <td colspan="4">
                                            <b>Dirección de habitación:</b>
                                            <span> {{  $estudiante->representantes[0]->direccion ?? '' }} </span>
                                        </td>
                                    </tr>
                                </tbody>
                                @endif

                            <thead>
                                <tr>
                                    <th class="fs-4 text-center" colspan="4">Plan de Estudio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-start">
                                    <td>
                                        <b>Nivel a Cursar:</b>
                                        {{ $inscripcione->grupo['nivel']->nombre }} <br>
                                        <span> Libro: {{ $inscripcione->grupo['nivel']->libro }} </span>
                                    </td>
                                    <td>
                                        <b>Nombre del grupo de estudio:</b>
                                        <span>{{ $inscripcione->grupo['nombre'] }} </span>
                                    </td>
                                    <td>
                                        <b>Fecha de inicio:</b>
                                        <span> {{ $inscripcione->fecha_init }} </span>
                                    </td>
                                    <td>
                                        <b>Fecha de fin:</b>
                                        <span> {{ $inscripcione->fecha_end }} </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4">
                                        <b>Horario:</b>
                                        <span id="datos_plan_estudio_horario">
                                            {{ $inscripcione->hora_init . ' - ' . $inscripcione->hora_end }}
                                            <b>Dias:</b> {{ $inscripcione->grupo['dias'] }}
                                        </span>
                                    </td>
                                </tr>

                            </tbody>

                            <thead>
                                <tr>
                                    <th class="fs-4 text-center" colspan="4">Plan de Pago</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="text-start">
                                    <td>
                                        <b>Tipo de Plan:</b>
                                        <span> {{ $inscripcione->plan->nombre }} </span>
                                    </td>
                                    <td colspan="2">
                                        <b>Descripción del Plan:</b>
                                        <span>{{ $inscripcione->plan->descripcion }} <br>
                                            {{-- Cantidad de cuotas: {{ $inscripcione->plan->cantidad_cuotas }} </span> --}}
                                    </td>
                                    <td>
                                        <b>Valor del Nivel:</b>
                                        <span> Ref: {{ $inscripcione->grupo['nivel']->precio }} </span>
                                    </td>

                                </tr>

                                {{-- <tr>
                                    <td colspan="4">
                                        <b>Cuotas:</b>
                                        <ul id="datos_plan_pago_cuotas">
                                            @foreach ($inscripcione->cuotas as $cuota)
                                                <li class="d-inline ms-2">
                                                    <input type="checkbox" disabled {{ $cuota->estatus ? 'checked' : '' }}>
                                                    <label for="dif"> {{ $cuota->cuota }} | {{ date_format(date_create($cuota->fecha), "d-m-Y") }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr> --}}

                            </tbody>
                            <thead>
                                <tr>
                                    <th class="fs-4 text-center" colspan="4">Datos Extras</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <b>¿Promoción?</b> 
                                        <span class="fs-5 ps-2">{{ explode(",", $inscripcione->extras)[0] ?? ''  }}</span>
                                    </td>
                                    <td colspan="3">
                                        <b>Explique: </b> 
                                        <span class="fs-5 ps-2">{{ explode(",", $inscripcione->extras)[1] ?? '' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>¿Se entrego material?</b> 
                                        <span class="fs-5 ps-2">{{ explode(",", $inscripcione->extras)[2] ?? '' }}</span>
                                    </td>
                                    <td colspan="3">
                                        <b>¿Como se entero del curso?: </b> 
                                        <span class="fs-5 ps-2">{{ explode(",", $inscripcione->extras)[3] ?? '' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <b>Observación: </b> 
                                        <span class="fs-5 ps-2">{{ explode(",", $inscripcione->extras)[4] ?? '' }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="card-footer">
                        <img src="assets/img/Planilla-footer.png" alt="">
                    </div>
                </div>
            </div>

            <div class="col-lg-12 d-flex  ">
                <p class="text-center col-6  mt-3">
                    <a href="/inscripciones/{{ $inscripcione->cedula_estudiante }}/{{ $inscripcione->codigo }}"
                        class="btn btn-primary btn-lg" target="_self" id="imprimirRecibo">
                        <i class="bi bi-printer"></i>
                        Imprimir Planilla
                    </a>
                </p>

                <p class="text-center col-6 mt-3">
                    <a href="/pagos/{{ $inscripcione->cedula_estudiante }}/{{ $inscripcione->codigo }}"
                        class="btn btn-primary btn-lg" target="_self" id="procesarPago">
                        <i class="bi bi-paypal" ></i>
                        Procesar pago
                    </a>
                </p>
            </div>

            {{-- <img src="assets/img/planilla.png" class="align-self-center"  alt=""> --}}

        </div>
    </section>





@endsection
