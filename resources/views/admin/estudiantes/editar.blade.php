@extends('layouts.app')

@section('title', 'Editar Estudiante')


@section('content')

  @isset($respuesta)
    @include('partials.alert')  
  @endisset

  <div class="container">

    <section class="section register d-flex flex-column align-items-center justify-content-center ">
      <div class="container">
        <div class="row justify-content-center">
          <div class=" col-sm-10 d-flex flex-column align-items-center justify-content-center">

            <div class="card">

              <div class="card-header">
                <div class=" pb-2">
                  <h5 class="card-title text-center pb-0 fs-2">Actualizar Estudiante</h5>
                  <p class="text-center text-danger small">Rellene todos los campos </p>
                </div>
                <div class="col-xs-12 col-sm-6">
                  <img src="{{ asset($estudiante->foto) }}" class="img-thumbnail" width="75" alt="Foto">
                  
                </div>
              </div>
              <div class="card-body">

                <form action="{{ route('admin.estudiantes.update', $estudiante->id) }}" method="POST"
                  class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                  @csrf
                  @method('put')

                  <input type="hidden" name="urlPrevia"
                        value="{{$urlPrevia}}"
                        required> 

                  {{-- INICIO DE DATOS PERSONALES --}}
                  <div class="col-12">
                      <label for="yourUsername" class="form-label">Nombre y apellido</label>
                      <div class="input-group has-validation">
                          <span class="input-group-text text-white bg-primary" id="inputGroupPrepend">
                              <i class="bi bi-people"></i>
                          </span>
                          <input type="text" name="nombre" class="form-control" id="yourUsername"
                              placeholder="Ingrese su nombres y apellidos"
                              value="{{ $estudiante->nombre ?? old('nombre') }}" required>
                          <div class="invalid-feedback">Por favor, ingrese nombre! </div>
                          @error('nombre')
                              <div class="text-danger">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-xs-12 col-sm-4">
                      <label for="validationCustom04" class="form-label">Nacionalidad</label>
                      <select name="nacionalidad" class="form-select" id="validationCustom04" required>
                          @if (old('nacionalidad'))
                              <option value="{{ old('nacionalidad') }}" selected>
                                  {{ old('nacionalidad') }}
                              </option>
                          @endif
                          @if ($estudiante->nacionalidad)
                              <option value="{{ $estudiante->nacionalidad }}" selected>
                                  {{ $estudiante->nacionalidad }}
                              </option>
                          @endif


                          <option value="">Seleccione Nacionalidad</option>
                          <option value="V">V</option>
                          <option value="E">E</option>
                      </select>
                      <div class="invalid-feedback">
                          Por favor, ingresar nacionalidad!
                      </div>
                      @error('nacionalidad')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

                  {{-- Cedula --}}
                  <div class="col-xs-12 col-sm-4">
                      <label for="yourPassword" class="form-label">Cédula</label>
                      <div class="input-group">
                          <input type="text" name="cedula" class="form-control bg-muted" id="inputCedula"
                              placeholder="Ingrese número de cédula"
                              value="{{ $estudiante->cedula ?? old('cedula') }}" disabled readonly required>
                          <button type="button" class="btn btn-warning" id="activarEdicionDeCedula"
                          data-bs-toggle="tooltip" data-bs-placement="top" title="Activar o desactivar edición de cédula">
                              <i class="bi bi-pencil"></i>
                          </button>
                      </div>
                      <div class="invalid-feedback">Por favor, Ingrese número de cédula!</div>
                      @error('cedula')
                          <div class="text-danger"> {{ $message }} </div>
                      @enderror
                  </div>



                  <div class="col-xs-12 col-sm-4">
                      <label for="yourPassword" class="form-label">Teléfono</label>
                      <input type="text" name="telefono" class="form-control" id="yourUsername"
                          placeholder="Ingrese número de teléfono"
                          value="{{ $estudiante->telefono ?? old('telefono') }}" min="11" max="15"
                          required>
                      <div class="invalid-feedback">Por favor, Ingrese número de teléfono!
                      </div>
                      @error('telefono')
                          <div class="text-danger"> {{ $message }} </div>
                      @enderror
                  </div>

                  <div class="col-xs-12 col-sm-4">
                      <label for="yourPassword" class="form-label">E-mail</label>
                      <input type="email" name="correo" class="form-control" id="yourUsername"
                          placeholder="Ingrese dirección de correo."
                          value="{{ $estudiante->correo ?? old('correo') }}" required>
                      <div class="invalid-feedback">Por favor, Ingrese dirección de correo!
                      </div>
                      @error('correo')
                          <div class="text-danger"> {{ $message }} </div>
                      @enderror
                  </div>

                  <div class="col-xs-12 col-sm-4">
                      <label for="yourPassword" class="form-label">Fecha de nacimiento</label>
                      <input type="date" name="nacimiento" class="form-control" id="fecha_nacimiento"
                          placeholder="Ingrese fecha de nacimiento."
                          value="{{ $estudiante->nacimiento ?? old('nacimiento') }}" required>
                      <div class="invalid-feedback">Por favor, ingrese fecha de nacimiento!
                      </div>
                      @error('nacimiento')
                          <div class="text-danger"> {{ $message }} </div>
                      @enderror
                  </div>

                  <div class="col-xs-12 col-sm-4">
                      <label for="yourPassword" class="form-label">Edad</label>
                      <input type="number" name="edad" class="form-control" id="edad_estudiante"
                          placeholder="Ingrese edad." value="{{ $estudiante->edad ?? old('edad') }}"
                          min="1" max="120" required>
                      <div class="invalid-feedback">Por favor, Ingrese edad!</div>
                      @error('edad')
                          <div class="text-danger"> {{ $message }} </div>
                      @enderror
                  </div>

                  <div class="col-12">
                      <label for="yourPassword" class="form-label">Dirección de
                          habitación</label>
                      <input type="text" name="direccion" class="form-control" id="yourUsername"
                          placeholder="Ingrese dirección de domicilio."
                          value="{{ $estudiante->direccion ?? old('direccion') }}" required>
                      <div class="invalid-feedback">Por favor, Ingrese dirección!</div>
                      @error('direccion')
                          <div class="text-danger"> {{ $message }} </div>
                      @enderror
                  </div>

                  <div class="col-12">
                      <label for="yourPassword" class="form-label">Grado de estudio</label>
                      <input type="text" name="grado" class="form-control" id="yourUsername"
                          placeholder="Ingrese grado de estudio."
                          value="{{ $estudiante->grado ?? old('grado') }}" required>
                      <div class="invalid-feedback">Por favor, Ingrese grado de estudio!
                      </div>
                      @error('grado')
                          <div class="text-danger"> {{ $message }} </div>
                      @enderror
                  </div>
                  <div class="col-12">
                      <label for="yourPassword" class="form-label">Ocupación o
                          profesión</label>
                      <input type="text" name="ocupacion" class="form-control" id="yourUsername"
                          placeholder="Ingrese ocupación."
                          value="{{ $estudiante->ocupacion ?? old('ocupacion') }}" required>
                      <div class="invalid-feedback">Por favor, Ingrese ocupación!</div>
                      @error('ocupacion')
                          <div class="text-danger"> {{ $message }} </div>
                      @enderror
                  </div>


                  <div class="col-xs-12 col-sm-6">
                      <label for="foto" class="form-label">Subir Foto (Opcional)</label>
                      <input type="file" name="file" class="form-control " id="file"
                          accept="image/*">
                      @error('file')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                  </div>

              
                  {{-- FIN DE DATOS PERSONALES --}}



                  {{-- INICIO DE DATOS DEL REPRESENTANTE --}}
                  <div  class="row">
                      <div class="col-xs-8 col-sm-12">
                          <h5 class="mt-3">Editar datos del representante </h5>
                          <hr>
                      </div>

                      <div class="col-sm-12">
                          <label for="yourUsername" class="form-label">Cédula del 
                              representante</label><br>
                          <input type="number" name="rep_cedula" class="form-control"
                              value="{{ old('rep_cedula') ?? $estudiante->representantes[0]->representante->cedula  }}" id="rep_cedula"
                              placeholder="Ingrese la cédula del representante.">
                          <p><small class="text-white card mt-2 p-2 bg-secondary" id="mensajeRepresentante">
                                  Si el representante ya existe los datos se llenaran
                                  automáticamente.
                              </small></p>
                          <div class="invalid-feedback">Por favor, Ingrese la cédula del
                              representante!
                          </div>
                      </div>
                      {{-- Se muestra la precarga  --}}
                      <span id="preload"></span>
                      <div id="componenteRepresentante" class="row">
                          <div class="col-sm-12">
                              <label for="yourName" class="form-label">Nombre del
                                  representante</label>
                              <input type="text" name="rep_nombre" class="form-control" id="yourName"
                                  value="{{ old('rep_nombre') ?? $estudiante->representantes[0]->representante->nombre }}"
                                  placeholder="Ingrese Nombre del representante.">
                              <div class="invalid-feedback">Por favor, Nombre del
                                  representante!</div>
                          </div>

                          <div class="col-xs-12 col-sm-6">
                              <label for="yourUsername" class="form-label">Teléfono </label>
                              <input type="number" name="rep_telefono" class="form-control"
                                  value="{{ old('rep_telefono') ?? $estudiante->representantes[0]->representante->telefono }}" id="yourUsername"
                                  placeholder="Ingrese teléfono del representante.">
                              <div class="invalid-feedback">Por favor, Ingrese teléfono del
                                  representante!
                              </div>
                          </div>

                          <div class="col-xs-12 col-sm-6">
                              <label for="yourUsername" class="form-label">Edad</label>
                              <input type="number" name="rep_edad" class="form-control" id="yourUsername"
                                  value="{{ old('rep_edad') ?? $estudiante->representantes[0]->representante->edad }}" placeholder="Ingrese edad.">
                              <div class="invalid-feedback">Por favor, Ingrese edad!</div>
                          </div>

                          <div class="col-12">
                              <label for="yourUsername" class="form-label">Ocupación</label>
                              <input type="text" name="rep_ocupacion" class="form-control"
                                  value="{{ old('rep_ocupacion') ?? $estudiante->representantes[0]->representante->ocupacion }}" id="yourUsername"
                                  placeholder="Ingrese ocupación o oficio.">
                              <div class="invalid-feedback">Por favor, ocupación o oficio!
                              </div>
                          </div>

                          <div class="col-12">
                              <label for="yourUsername" class="form-label">Dirección del
                                  representante</label>
                              <input type="text" name="rep_direccion" class="form-control"
                                  value="{{ old('rep_direccion') ?? $estudiante->representantes[0]->representante->direccion }}" id="yourUsername"
                                  placeholder="Ingrese dirección del representante.">
                              <div class="invalid-feedback">Por favor, Ingrese dirección del
                                  representante!
                              </div>
                          </div>

                          <div class="col-12">
                              <label for="yourUsername" class="form-label">Correo</label>
                              <input type="email" name="rep_correo" class="form-control"
                                  value="{{ old('rep_correo')  ?? $estudiante->representantes[0]->representante->correo }}" id="yourUsername"
                                  placeholder="Ingrese correo.">
                              <div class="invalid-feedback">Por favor, Ingrese correo
                                  electrónico correcto!
                              </div>
                          </div>
                      </div>
                  </div> {{-- FIN DE DATOS DEL REPRESENTANTE --}}

                  {{-- INICIO DE DATOS DE DIFICULTAD DE APRENDIZAJE --}}
                  <div class="row">
                      <div class="col-12">
                          <h5 class="mt-3"> Editar dificultades de aprendizaje</h5>
                          <hr>
                      </div>
                   
                      @foreach ($estudiante->dificultades as $key => $dificultad)
                          
                        <div class="col-4">
                            <label for="yourUsername" class="form-label">{{ $dificultad->dificultad }}</label>
                            <input type="checkbox" name="dif_{{$key+1}}" value="{{$dificultad->dificultad}}" class="form-checkbox"
                                {{ $dificultad->estatus ? 'checked' : '' }}
                                id="yourUsername">
                        </div>
                      @endforeach
                      
                  </div> {{-- INICIO DE DATOS DE DIFICULTAD DE APRENDIZAJE --}}



                  
                  
                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Guardar datos</button>
                  </div>

                  <div class="">

                 
                    <a class=" invisible" id="addRepre">
                       
                    </a>
              

                    <a class=" invisible" id="addDifi">
                      
                    </a>
                  </div> 

              </form>
         

              </div>

            </div>

         
          </div>
        </div>
      </div>

    </section>
    <script src="{{ asset('assets/js/profesores/editar.js') }}"></script>
    <script src="{{ asset('assets/js/estudiantes/editar.js') }}"></script>
    <script src="{{ asset('assets/js/estudiantes/create.js') }}"></script>
    <script src="{{ asset('assets/js/representantes/getRepresentante.js') }}" defer></script>
  </div>
@endsection

{{-- 
--}}

{{-- Cedula --}}
{{-- <div class="col-xs-12 col-sm-4">
  <label for="yourPassword" class="form-label">Cédula</label>
  <div class="input-group">
    <input type="text" name="cedula" class="form-control bg-muted" id="inputCedula" 
    placeholder="Ingrese número de cédula"
    value="{{ $estudiante->cedula ?? old('cedula') }}"
    disabled
    readonly
    required>
    <button type="button" class="btn btn-warning" id="activarEdicionDeCedula">
      <i class="bi bi-pencil"></i>
    </button>
  </div>
  <div class="invalid-feedback">Por favor, Ingrese número de cédula!</div>
  @error('cedula')
    <div class="text-danger"> {{ $message }} </div>
  @enderror
</div> --}}
