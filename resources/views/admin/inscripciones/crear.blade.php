@extends('layouts.app')

@section('title', 'Registrar inscripción')


@section('content')
    @isset($respuesta)
        @include('partials.alert')
    @endisset
    <div id="alert"></div>

    <div class="container">
        <section class="section register d-flex flex-column align-items-center justify-content-center ">
            <div class="container">
                <div class="row justify-content-center">
                    <div class=" col-sm-12 d-flex flex-column align-items-center justify-content-center">

                        <div class="card ">

                            <div class="card-body">

                                <div class=" pb-2">
                                    <h5 class="card-title text-center pb-0 fs-2">Registrar Inscripción</h5>
                                    <p class="text-center text-danger small">Rellene todos los campos</p>
                                </div>

                                <form action="/inscripciones" method="post" class="row g-3 needs-validation" target="_self"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('post')

                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Número de control
                                            <span class=" text-primary">(Es automático)</span>
                                        </label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text text-white bg-primary" id="inputGroupPrepend">
                                                <i class="bi bi-upc-scan"></i>
                                            </span>
                                            <input type="text" name="codigo" class="form-control fs-5 text-danger"
                                                id="yourUsername" value="{{ $codigo ?? $request->codigo }}" readonly
                                                required>
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
                                                id="cedula" value="{{ $request->cedula_estudiante ?? '' }}"
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
                                            <option value="">Seleccione Plan de pago</option>

                                            @foreach ($planes as $plane)
                                                @isset($request->codigo_plan)
                                                    @if ($plane->codigo == $request->codigo_plan)
                                                        <option value="{{ $plane->codigo }}" selected>{{ $plane->nombre }} -
                                                            Cuotas:
                                                            {{ $plane->cantidad_cuotas }}</option>
                                                    @endif
                                                @endisset
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
                                            placeholder="Ingrese fecha de pago." value="{{ date('Y-m-d') }}" required>
                                        <div class="invalid-feedback">Por favor, Ingrese Fecha de inscripción!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="validationCustom04" class="form-label">Asigne Grupo de Estudio</label>
                                        <select name="codigo_grupo" class="form-select" id="codigo_grupo" required>
                                            <option selected disabled value="">Seleccione Grupo</option>

                                            @foreach ($grupos as $grupo)
                                                @isset($request->codigo_grupo)
                                                    @if ($grupo->codigo == $request->codigo_grupo)
                                                        <option value="{{ $grupo->codigo }}" selected>{{ $grupo->codigo }} -
                                                            {{ $grupo->nombre }} - Matricula: {{ $grupo->matricula }}</option>
                                                    @endif
                                                @endisset
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


                                    {{-- Datos Extras --}}
                                    <div class="col-sm-12">
                                        <h3>
                                            Datos extras
                                            <small class="text-muted fs-6">(Estos datos son opcionales)</small>
                                        </h3>
                                        <hr>
                                    </div>
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">¿Promoción? </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="ext_promo" value="si"
                                                id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Si
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="ext_promo" value="no"
                                                id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                No
                                            </label>
                                        </div>
                                        <div class="input-group mb-3 form-check-inline">
                                            <span class="input-group-text bg-primary text-white"
                                                id="inputGroup-sizing-sm">Explique</span>
                                            <input type="text" class="form-control" name="ext_explique"
                                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">¿Se entrego material? </label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="ext_material"
                                                value="si" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Si
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="ext_material"
                                                value="no" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                No
                                            </label>
                                        </div>
                                        <div class="input-group mb-3 form-check-inline">
                                            <span class="input-group-text bg-primary text-white"
                                                id="inputGroup-sizing-sm">¿Como se entero del curso?</span>
                                            <input type="text" class="form-control" name="ext_alcanzado"
                                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                        <div class="input-group mb-3 form-check-inline">
                                            <span class="input-group-text bg-primary text-white"
                                                id="inputGroup-sizing-sm">Observación</span>
                                            <input type="text" class="form-control" name="ext_observacion"
                                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        </div>
                                    </div>



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
