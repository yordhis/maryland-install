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
                                    <h5 class="card-title text-center pb-0 fs-2">Editar plan de pago</h5>
                                    <p class="text-center text-danger small">Rellene todos los campos</p>
                                </div>




                                <form action="{{ route('admin.planes.update', $plane->id) }}" method="post"
                                    class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('put')

                                    <input type="hidden" name="urlPrevious" value="{{ old('urlPrevious') ?? $urlPrevious }}">

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
                                        @error('codigo')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Nombre del plan</label>
                                        <input type="text" name="nombre" class="form-control" id="yourUsername"
                                            placeholder="Ingrese nombre del nivel" value="{{ old('nombre') ?? $plane->nombre }}" required>
                                        <div class="invalid-feedback">Por favor, Ingrese nombre del plan!</div>

                                        @error('nombre')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Decripcion del plan</label>
                                        <input type="text" name="descripcion" class="form-control" id="yourUsername"
                                            placeholder="Ingrese la descripción del plan." value="{{ old('descripcion') ?? $plane->descripcion }}"
                                            required>
                                        <div class="invalid-feedback">Por favor, Ingrese la descripción del plan!</div>
                                        @error('descripcion')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
