@extends('layouts.app')

@section('title', 'Crear Usuario')


@section('content')

  @isset($respuesta)
    @include('partials.alert')  
  @endisset

<div class="container">
    <section class="section register d-flex flex-column align-items-center justify-content-center ">
      <div class="container">
        <div class="row justify-content-center">
          <div class=" col-sm-8 d-flex flex-column align-items-center justify-content-center">

            <div class="card ">

              <div class="card-body">

                <div class=" pb-2">
                  <h5 class="card-title text-center pb-0 fs-2">Crear Profesor</h5>
                  <p class="text-center text-danger small">Rellene todos los campos</p>
                </div>

                


                <form action="/profesores" method="post" class="row g-3 needs-validation" target="_self" 
                enctype="multipart/form-data"
                novalidate>
                 @csrf
                 @method('post')  
                 
                  <div class="col-12">
                        <label for="yourUsername" class="form-label">Nombre y apellido</label>
                        <div class="input-group has-validation">
                          <span class="input-group-text text-white bg-primary" id="inputGroupPrepend">@</span>
                          <input type="text" name="nombre" class="form-control" id="yourUsername" 
                          placeholder="Ingrese su nombres y apellidos"
                          value="{{ $request->nombre ?? '' }}"
                          required>
                          <div class="invalid-feedback">Por favor, ingrese nombre! </div>
                        </div>
                      </div>

                      <div class="col-4">
                        <label for="validationCustom04" class="form-label">Nacionalidad</label>
                        <select name="nacionalidad"  class="form-select" id="validationCustom04" required>
                          @if (isset($request->nacionalidad))
                            <option value="{{ $request->nacionalidad }}" selected >{{ $request->nacionalidad }}</option>
                          @endif
                          <option value="">Seleccione Nacionalidad</option>
                          <option value="V">V</option>
                          <option value="E">E</option>
                        </select>
                        <div class="invalid-feedback">
                         Por favor, ingresar nacionalidad!
                        </div>
                      </div>
                     
    
                      <div class="col-4">
                        <label for="yourPassword" class="form-label">Cédula</label>
                        <input type="text" name="cedula" class="form-control" id="yourUsername" 
                        placeholder="Ingrese número de cédula"
                        value="{{ $request->cedula ?? '' }}"
                        required>
                        <div class="invalid-feedback">Por favor, Ingrese número de cédula!</div>
                      </div>

                      <div class="col-4">
                        <label for="yourPassword" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" id="yourUsername" 
                        placeholder="Ingrese número de teléfono"
                        value="{{ $request->telefono ?? '' }}"
                        required>
                        <div class="invalid-feedback">Por favor, Ingrese número de teléfono!</div>
                      </div>

                      <div class="col-4">
                        <label for="yourPassword" class="form-label">E-mail</label>
                        <input type="email" name="correo" class="form-control" id="yourUsername" 
                        placeholder="Ingrese dirección de correo."
                        value="{{ $request->correo ?? '' }}"
                        >
                        <div class="invalid-feedback">Por favor, Ingrese dirección de correo!</div>
                      </div>

                      <div class="col-4">
                        <label for="yourPassword" class="form-label">Fecha de nacimiento</label>
                        <input type="date" name="nacimiento" class="form-control" id="yourUsername" 
                        placeholder="Ingrese fecha de nacimiento."
                        value="{{ $request->nacimiento ?? '' }}"
                        required>
                        <div class="invalid-feedback">Por favor, ingrese fecha de nacimiento!</div>
                      </div>

                      <div class="col-4">
                        <label for="yourPassword" class="form-label">Edad</label>
                        <input type="number" name="edad" class="form-control" id="yourUsername" 
                        placeholder="Ingrese edad."
                        value="{{ $request->edad ?? '' }}"
                        required>
                        <div class="invalid-feedback">Por favor, Ingrese edad!</div>
                      </div>

                      <div class="col-12">
                        <label for="yourPassword" class="form-label">Dirección de habitación</label>
                        <input type="text" name="direccion" class="form-control" id="yourUsername" 
                        placeholder="Ingrese dirección de domicilio."
                        value="{{ $request->direccion ?? '' }}"
                        required>
                        <div class="invalid-feedback">Por favor, Ingrese edad!</div>
                      </div>

                      <div class="col-12">
                        <label for="file" class="form-label">Subir Foto (Opcional)</label>
                        <input type="file" name="file" class="form-control " id="file">
                        {{-- <div class="invalid-feedback">Ingrese una imagen valida</div> --}}
                      </div>

                  

                  
                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Crear profesor</button>
                  </div>
                  
                </form>

              </div>
            </div>

            {{-- <div class="credits"> --}}
              <!-- All the links in the footer should remain intact. -->
              <!-- You can delete the links only if you purchased the pro version. -->
              <!-- Licensing information: https://bootstrapmade.com/license/ -->
              <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
               {{-- <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
            {{-- </div> --}}

          </div>
        </div>
      </div>

    </section>
@endsection


