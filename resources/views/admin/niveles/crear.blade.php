@extends('layouts.app')

@section('title', 'Crear Usuario')


@section('content')

    @isset($respuesta)
        @include('partials.alert')
    @endisset
    <div id="alert"></div>

    <div class="container">
        <section class="section register d-flex flex-column align-items-center justify-content-center ">
            <div class="container">
                <div class="row justify-content-center">
                    <div class=" col-sm-8 d-flex flex-column align-items-center justify-content-center">

                        <div class="card ">

                            <div class="card-body">

                                <div class=" pb-2">
                                    <h5 class="card-title text-center pb-0 fs-2">Crear Nivel</h5>
                                    <p class="text-center text-danger small">Rellene todos los campos</p>
                                </div>




                                <form action="/niveles" method="post" class="row g-3 needs-validation" target="_self"
                                    enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('post')

                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Código
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
                                        <label for="yourPassword" class="form-label">Nombre del nivel</label>
                                        <input type="text" name="nombre" class="form-control" id="yourUsername"
                                            placeholder="Ingrese nombre del nivel" value="{{ $request->nombre ?? '' }}"
                                            required>
                                        <div class="invalid-feedback">Por favor, Ingrese nombre del nivel!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Precio</label>
                                        <input type="number" name="precio" class="form-control" id="yourUsername"
                                            placeholder="Ingrese costo del nivel" value="{{ $request->precio ?? '' }}"
                                            required>
                                        <div class="invalid-feedback">Por favor, Ingrese costo del nivel!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Libro</label>
                                        <input type="text" name="libro" class="form-control" id="yourUsername"
                                            placeholder="Ingrese nombre del libro para este nivel."
                                            value="{{ $request->libro ?? '' }}" required>
                                        <div class="invalid-feedback">Por favor, Ingrese nombre del libro para este nivel!
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <label for="yourPassword" class="form-label">Tiempo de duración del nivel</label>
                                        <input type="number" name="duracion" class="form-control" id="yourUsername"
                                            placeholder="Ingrese Tiempo de duración del nivel."
                                            value="{{ $request->duracion ?? '' }}" required>
                                        <div class="invalid-feedback">Por favor, Tiempo de duración del nivel!</div>
                                    </div>

                                    <div class="col-4">
                                        <label for="validationCustom04" class="form-label">Tipo de tiempo</label>
                                        <select name="tipo_duracion" class="form-select" id="validationCustom04" required>
                                            @if (isset($request->tipo_duracion))
                                                <option value="{{ $request->tipo_duracion }}" selected>
                                                    {{ $request->tipo_duracion }}</option>
                                            @endif
                                            <option selected disabled value="">Seleccione el tiempo</option>
                                            <option value="Dias">Dias</option>
                                            <option value="Meses">Meses</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor, Seleccione tiempo!
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Crear nivel</button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>
    @endsection
