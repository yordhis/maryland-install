 <!-- Modal Dialog Scrollable -->
 <a type="button" class="" data-bs-toggle="modal" data-bs-target="#modalDialogScrollable{{$estudiante->id}}">
    <i class="bi bi-eye"></i>
 </a>
  <div class="modal fade" id="modalDialogScrollable{{$estudiante->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Informacion del estudiante</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <section class="section profile">
            <div class="row">

              <div class="col-xl-12">

                <div class="card">
                  <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <img src="{{$estudiante->foto}}" alt="Profile" class="rounded-circle">
                    <h2>  {{$estudiante->nombre}} </h2>
                    <h3>{{$estudiante->edad}} Años</h3>

                    <div class="container-fluid">
                      <div class="row">
                        <hr>
                        <div class="col-md-12">
                          <h3>Datos Perosnales</h3>
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Cédula:</span> {{$estudiante->nacionalidad}}-{{$estudiante->cedula}} 
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Teléfono:</span> {{$estudiante->telefono}} 
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Correo:</span> {{$estudiante->correo}}
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Fecha de nacimiento:</span> {{$estudiante->nacimiento}}
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Direccion de domicilio:</span> {{$estudiante->direccion}}
                        </div>
                        <div class="col-md-12 label"> 
                          <span class="text-primary">Mi dificultad de aprendizaje:</span> 

                          @if(isset($estudiante->dificultades))

                            @foreach ($estudiante->dificultades as $dificultad)
                              @if($dificultad->estatus)
                                {{$dificultad->dificultad}} /
                              @endif
                            @endforeach
                          @else
                            <span class="text-default">No posee dificultad</span>
                          @endif
                          
                        </div>
                     
                   
                        
                      </div>
                    </div>
                  </div>
                </div>
      
              </div>
              <div class="col-xl-12">

                <div class="card">
                  <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                   

                    <div class="container-fluid">
                      <div class="row">
                        <hr>
                        <div class="col-md-12">
                          <h3>Datos Del Representante</h3>
                        </div>

                        @if(isset($estudiante->representantes[0]))
                          @foreach ($estudiante->representantes as $representante)
                              
                            <div class="col-md-12 label"> 
                              <span class="text-primary">Cédula:</span> {{$representante->data->cedula}} 
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Teléfono:</span> {{$representante->data->telefono}} 
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Correo:</span> {{$representante->data->correo}}
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Ocupación:</span> {{$representante->data->ocupacion}}
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Direccion de domicilio:</span> {{$representante->data->direccion}}
                            </div>

                          @endforeach
                        @else
                          <span class="text-danger">{{ "No tiene representante asignado" }}</span>
                        @endif
                       
                     
                   
                        
                      </div>
                    </div>
                  </div>
                </div>
      
              </div>
            



            </div>
          </section>
          
          
            
          


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div><!-- End Modal Dialog Scrollable-->