@extends('layouts.app')

@section('title', 'Editar Plan de Pago')


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




                                <form action="/planes/{{ $plane->id }}" method="post" class="row g-3 needs-validation"
                                    target="_self" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('put')

                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Código
                                            <span class=" text-primary">(Es automático)</span>
                                        </label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text text-white bg-primary" id="inputGroupPrepend">
                                                <i class="bi bi-upc-scan"></i>
                                            </span>
                                            <input type="text" name="codigo" class="form-control fs-5 text-danger"
                                                id="yourUsername" value="{{ $plane->codigo }}" readonly required>
                                            <div class="invalid-feedback">Por favor, ingrese codigo! </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Nombre del plan</label>
                                        <input type="text" name="nombre" class="form-control" id="yourUsername"
                                            placeholder="Ingrese nombre del nivel" value="{{ $plane->nombre }}" required>
                                        <div class="invalid-feedback">Por favor, Ingrese nombre del plan!</div>
                                    </div>

                                    <div class="col-4">
                                        <label for="yourPassword" class="form-label">Cantidad de cuotas</label>
                                        <input type="number" name="cantidad_cuotas" class="form-control" id="yourUsername"
                                            placeholder="Ingrese costo del nivel" value="{{ $plane->cantidad_cuotas }}"
                                            required>
                                        <div class="invalid-feedback">Por favor, Ingrese cantidad de cuotas!</div>
                                    </div>

                                    <div class="col-8">
                                        <label for="validationCustom04" class="form-label">Plazo de pago</label>
                                        <select name="plazo" class="form-select" id="validationCustom04" required>
                                            <option selected disabled value="">Seleccione cantidad de dias</option>
                                            @if (isset($plane->plazo))
                                                <option value="{{ $plane->plazo }}" selected>{{ $plane->plazo }} Días
                                                </option>
                                            @endif
                                            <option value="1">1 Día</option>
                                            <option value="7">7 Días</option>
                                            <option value="15">15 Días</option>
                                            <option value="30">30 Días</option>
                                            <option value="45">45 Días</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor, Seleccione plazo de pago!
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Decripcion del plan</label>
                                        <input type="text" name="descripcion" class="form-control" id="yourUsername"
                                            placeholder="Ingrese la descripción del plan." value="{{ $plane->descripcion }}"
                                            required>
                                        <div class="invalid-feedback">Por favor, Ingrese la descripción del plan!</div>
                                    </div>




                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Guardar cambios</button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>
    @endsection
