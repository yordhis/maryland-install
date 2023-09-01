@extends('layouts.app')

@section('title', 'Registrar inscripción')


@section('content')
    @isset($respuesta['activo'])
        @include('partials.alert')
    @endisset

    <div class="container">
        <section class="section register d-flex flex-column align-items-center justify-content-center ">
            <div class="container">
                <div class="row justify-content-center">
                    <div class=" col-sm-12 d-flex flex-column align-items-center justify-content-center">

                        <div class="card ">

                            <div class="card-body">

                                <div class=" pb-2">
                                    <h5 class="card-title text-center pb-0 fs-2">Editar Inscripción</h5>
                                    <p class="text-center text-danger small">Rellene todos los campos</p>
                                </div>




                                <form action="/inscripciones/{{ $inscripcione->id }}" method="post"
                                    class="row g-3 needs-validation" target="_self" enctype="multipart/form-data"
                                    novalidate>
                                    @csrf
                                    @method('put')

                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Número de control
                                            <span class=" text-primary">(Es automático)</span>
                                        </label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text text-white bg-primary" id="inputGroupPrepend">
                                                <i class="bi bi-upc-scan"></i>
                                            </span>
                                            <input type="text" name="codigo" class="form-control fs-5 text-danger"
                                                id="yourUsername" value="{{ $inscripcione->codigo }}" readonly required>
                                            <div class="invalid-feedback">Por favor, ingrese codigo! </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Cédula del estudiante</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text text-white bg-primary" id="inputGroupPrepend">
                                                <a href="#" target="_self" class="text-white fs-5"
                                                    id="buscarEstudiante">
                                                    <i class="bi bi-search"></i>
                                                </a>
                                            </span>
                                            <input type="text" name="cedula_estudiante" class="form-control fs-5"
                                                id="cedula"
                                                value="{{ $inscripcione->cedula_estudiante ?? $request->cedula_estudiante }}"
                                                placeholder="Ingrese Cédula del estudiante" required>
                                            <div class="invalid-feedback">Por favor, Ingrese cédula del estudiante!</div>
                                        </div>
                                    </div>

                                    {{-- Mostramos la tarjeta informativa del estudiante --}}
                                    <div id="dataEstudiante">

                                    </div>{{-- ##FIN la tarjeta informativa del estudiante --}}

                                    {{-- Mostramos las cuotas pendiente del estudiante --}}
                                    <div id="cuotasEstudiante">

                                    </div>{{-- ##FIN cuotas pendiente del estudiante --}}

                                    <div class="col-6">
                                        <label for="validationCustom04" class="form-label">Asigne Plan de pago</label>
                                        <select name="codigo_plan" class="form-select" id="validationCustom04" required>
                                            <option selected disabled value="">Seleccione Plan de pago</option>
                                           
                                            @foreach ($planes as $plane)
                                                @if (isset($inscripcione->codigo_plan))
                                                  @if ($inscripcione->codigo_plan == $plane->codigo)
                                                  <option value="{{ $plane->codigo }}" selected>{{ $plane->nombre }} - Cuotas:
                                                      {{ $plane->cantidad_cuotas }}</option>
                                                  @endif
                                                @endif

                                                <option value="{{ $plane->codigo }}">{{ $plane->nombre }} - Cuotas:
                                                    {{ $plane->cantidad_cuotas }}</option>
                                            @endforeach

                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor, Seleccione Plan de pago!
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <label for="yourPassword" class="form-label">Fecha de inscripción </label>
                                        <input type="date" name="fecha" class="form-control" id="yourUsername"
                                            placeholder="Ingrese fecha de pago." value="{{ $inscripcione->fecha ?? date('Y-m-d') }}" required>
                                        <div class="invalid-feedback">Por favor, Ingrese Fecha de inscripción!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="validationCustom04" class="form-label">Asigne Grupo de Estudio</label>
                                        <select name="codigo_grupo" class="form-select" id="codigo_grupo" required>
                                            <option selected disabled value="">Seleccione Grupo</option>

                                            @foreach ($grupos as $grupo)
                                                <option value="{{ $grupo->codigo }}">{{ $grupo->codigo }} -
                                                    {{ $grupo->nombre }} - Matricula: {{ $grupo->matricula }}</option>
                                            @endforeach

                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor, Seleccione Grupo de estudio!
                                        </div>
                                    </div>

                                    {{-- Mostramos los datos del grupo --}}
                                    <div id="grupoData">

                                    </div>{{-- ##FIN Mostramos los datos del grupo --}}





                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 boton" type="submit">Procesar
                                            Inscripción</button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>
    @endsection
