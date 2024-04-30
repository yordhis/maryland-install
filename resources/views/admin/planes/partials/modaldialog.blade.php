 <!-- Modal Dialog Scrollable -->
 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearPlan">
     <i class="bi bi-layout-text-sidebar-reverse"></i> Crear plan
 </button>

 <div class="modal fade" id="modalCrearPlan" tabindex="-1">
     <div class="modal-dialog modal-dialog-scrollable">
         <div class="modal-content">
             <div class="modal-header d-inline">
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 <h5 class="card-title text-center pb-0 fs-2">Crear Plan de pago</h5>
                 <p class="text-center text-danger small">Rellene todos los campos</p>
             </div>
             <div class="modal-body text-start">
                 <form action="{{ route('admin.planes.store') }}" method="post" class="row g-3 needs-validation"
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
                                 id="yourUsername" value="{{ $codigo ?? old('codigo') }}" readonly required>
                             <div class="invalid-feedback">Por favor, ingrese codigo! </div>
                         </div>
                     </div>

                     <div class="col-12">
                         <label for="yourPassword" class="form-label">Nombre del plan</label>
                         <input type="text" name="nombre" class="form-control" id="yourUsername"
                             placeholder="Ingrese nombre del nivel" value="{{ $request->nombre ?? old('nombre') }}"
                             required>
                         <div class="invalid-feedback">Por favor, Ingrese nombre del plan!</div>
                         @error('nombre')
                             <div class="text-danger">{{ $message }}</div>
                         @enderror
                     </div>

                     <div class="col-12">
                         <label for="yourPassword" class="form-label">Descripción del plan</label>
                         <input type="text" name="descripcion" class="form-control" id="descripcion"
                             value="{{ old('descripcion') ?? '' }}" placeholder="Ingrese descripción del plan..." required>
                         <div class="invalid-feedback">Por favor, Ingrese la descripción del plan!</div>
                         @error('descripcion')
                             <div class="text-danger">{{ $message }}</div>
                         @enderror
                     </div>

                     <div class="col-sm-4 col-xs-12 ">
                        <label for="yourPassword" class="form-label">Cantidad de cuotas</label>
                        <input type="number" name="cantidad_cuotas" class="form-control" id="yourUsername"
                            placeholder="Ingrese cantidad de cuotas"
                            value="{{ old('cantidad_cuotas') ?? $request->cantidad_cuotas }}" 
                            required>
                        <div class="invalid-feedback">Por favor, Ingrese cantidad de cuotas!</div>
                    </div>

                    <div class="col-sm-8 col-xs-12">
                        <label for="validationCustom04" class="form-label">Plazo de pago</label>
                        <select name="plazo" class="form-select" id="validationCustom04" required>
                            @if ( old('plazo') )
                              <option value="{{ old('plazo') }}" selected>{{ old('plazo') }} Días</option>
                            @endif

                            <option value="">Seleccione cantidad de dias</option>
                            <option value="1">1 Días</option>
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
                         <button class="btn btn-primary w-100" type="submit">Crear Plan de pago</button>
                     </div>

                 </form>
             </div>
        
         </div>
     </div>
 </div><!-- End Modal Dialog Scrollable-->
