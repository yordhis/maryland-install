@extends('layouts.app')

{{-- @section('title', 'Lista de Profesores') --}}

@section('content')
    @isset($respuesta['activo'])
        @include('partials.alert')
    @endisset

    <div id="alert"></div>

    <!-- Card with header and footer -->
    <div class="card rounded-5">
        <div class="card-header rounded-5 shadow bg-primary">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="text-white">Grupo {{ $grupo->nombre }} {{ $mensaje  ?? '' }}</h2>
                        <p class="text-white">
                            <b class="text-warning">Nivel:</b> {{ $grupo->nivel['nombre'] }} <br>
                            <b class="text-warning">Libro:</b> {{ $grupo->nivel['libro'] }} <br>
                            <b class="text-warning">Inversión:</b> {{ $grupo->nivel['precio'] }} $ <br>
                            <b class="text-warning">Matricula:</b> {{ $grupo->matricula }} estudiantes
                        </p>

                    </div>

                    <div class="col-sm-6 text-end">
                        <h2 class="text-white">Código: <b class="text-warning">{{ $grupo->codigo }}</b></h2>
                        <p class="text-white">
                            <b class="text-warning">Profesor:</b> {{ $grupo->profesor['nombre'] }} <br>
                            <b class="text-warning">Fecha de Inicio del curso:</b> {{ $grupo->fecha_inicio }} <br>
                            <b class="text-warning">Fecha de Finalización del curso:</b> {{ $grupo->fecha_fin }} <br>
                            <b class="text-warning">Horario:</b> De: {{ $grupo->hora_inicio }} hasta {{ $grupo->hora_fin }}
                            <br>
                            <b class="text-warning">Días:</b> {{ $grupo->dias }}

                        </p>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">Estudiantes</h5>

            @foreach ($grupo->estudiantes as $estudiante)
                <div class="card mb-3 rounded-5 shadow">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img src="{{ $estudiante->foto }}" class="img-fluid rounded-start" alt="foto">
                        </div>

                        <div class="col-md-4">
                            <div class="card-body">
                                <p class="card-text">
                                <h5 class="card-text text-dark">Estudiante</h5>
                                <b class="fs-5 text-primary"> {{ $estudiante->nombre }} </b> <br>
                                <small class="text-muted fs-6">{{ number_format($estudiante->cedula,0,',','.') }}</small> <br>
                                <small class="text-muted fs-6">{{ $estudiante->edad }} años</small>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card-body">
                                <p class="card-text">
                                <h5 class="card-text text-dark">Contacto</h5>
                                <b class="fs-5 text-primary"> {{ 
                                "(".substr( $estudiante['telefono'],0,4).")"." ".substr( $estudiante['telefono'],5,3)."-".substr( $estudiante['telefono'],6,4)
                                }} </b> <br>
                                <small class="text-muted fs-6">{{ $estudiante->correo }}</small> <br>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card-body">
                                <p class="card-text">
                                    <h5 class="card-text text-dark">Pagos</h5>
                                    <b class="fs-5 text-primary"> Pendientes </b> <br>
                                    @foreach ($estudiante->inscripciones as $inscripcion)
                                        @if ($inscripcion->codigo_grupo == $grupo->codigo)
                                            @foreach ($inscripcion->cuotas as $cuota)
                                                @if ($cuota->estatus == 0)
                                                    <small class="text-danger fs-6"> {{ $cuota->fecha }} |
                                                        {{ $cuota->cuota }}$</small> <br>
                                                @endif
                                            @endforeach

                                            </p>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card-body">
                                                    <p class="text-success"> Abonado: {{ $inscripcion->totalAbonado }}$</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach




            <div class="col-md-6">
                <div class="card-body">
                    <div class="d-flex flex-row-reverse ">
                        @include('admin.grupos.partials.modalEstudiante')

                        <a href="/pagos/{{ $estudiante->cedula }}/estudiante" target="_self">
                            <i class="bi bi-paypal fs-3 "></i>
                        </a>

                    </div>
                </div>
            </div>


        </div>
    </div>
    @endforeach

    </div>
    <div class="card-footer">
        <p class="text-center fs-6">
            Total de estudiantes: {{ $grupo->matricula }}
        </p>
    </div>
    </div><!-- End Card with header and footer -->
@endsection
