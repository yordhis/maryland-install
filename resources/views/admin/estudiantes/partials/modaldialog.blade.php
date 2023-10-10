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
                    <img src="{{ $estudiante->foto }}" alt="Profile" class="rounded-circle">
                    <h2>  {{ $estudiante->nombre }}</h2>
                    <h3>{{ $estudiante->edad }} Años</h3>

                    <div class="container-fluid">
                      <div class="row">
                        <hr>
                        <div class="col-md-12">
                          <h3>Datos Perosnales</h3>
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Cédula:</span> {{ $estudiante->nacionalidad }}-{{ $estudiante->cedula }} 
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Teléfono:</span> {{ $estudiante->telefono }} 
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Correo:</span> {{ $estudiante->correo }}
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Fecha de nacimiento:</span> 
                          @empty($estudiante->nacimiento)
                          {{ isset($estudiante->nacimiento) ? date_format(date_create($estudiante->nacimiento), "d-m-Y") : "" }}
                          
                          @endempty
                        </div>

                        <div class="col-md-12 label"> 
                          <span class="text-primary">Dirección de domicilio:</span> {{ $estudiante->direccion }}
                        </div>
                        <div class="col-md-12 label"> 
                          <span class="text-primary">Mi dificultad de aprendizaje:</span> 

                          @if(isset( $estudiante->dificultades ))
                            @php
                                $sinDificulta = true;
                            @endphp
                            @foreach ($estudiante->dificultades as $dificultad)
                              @if($dificultad->estatus)
                                @php
                                    $sinDificulta = false;
                                @endphp
                                {{$dificultad->dificultad}} /
                              @endif
                            @endforeach

                            @if ($sinDificulta)
                              <span class="text-default">No posee dificultad</span>
                            @endif
                          @endif
                          
                        </div>
                     
                   
                        
                      </div>
                    </div>
                  </div>
                </div>
      
              </div>
              {{-- Card Representante del estudiante --}}
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
                              <span class="text-primary">Nombre:</span> {{ $representante->nombre }} 
                            </div>
                            <div class="col-md-12 label"> 
                              <span class="text-primary">Cédula:</span> {{ $representante->cedula }} 
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Teléfono:</span> {{ $representante->telefono }} 
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Correo:</span> {{ $representante->correo }}
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Ocupación:</span> {{ $representante->ocupacion }}
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Direccion de domicilio:</span> {{ $representante->direccion }}
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

              {{-- Card Grupo de estudio --}}

              <div class="col-xl-12">

                <div class="card">
                  <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                   

                    <div class="container-fluid">
                      <div class="row">
                        <hr>
                        <div class="col-md-12">
                          <h3>Datos De Inscripción</h3>
                        </div>

                        @if(isset($estudiante->inscripciones[0]))
                          @foreach ($estudiante->inscripciones as $inscripcione)
                              
                            <div class="col-md-12 label"> 
                              <span class="text-primary">Codigo de inscripción:</span> {{$inscripcione->codigo}} 
                            </div>
                            <div class="col-md-12 label"> 
                              <span class="text-primary">Fecha de Inscripción:</span> {{ isset($inscripcione->fecha) ? date_format(date_create($inscripcione->fecha), "d-m-Y") : "" }} 
                            </div>

                            <div class="col-md-12 label"> 
                              {{-- <span class="text-primary">Observación:</span> {{ explode(",", $inscripcione->extras)[4] ? explode(",", $inscripcione->extras)[4] : "No hay observación asignada" }}  --}}
                            </div>

                            <div class="col-md-12 label mt-2"> 
                              <hr>
                              <h3>Grupo de Estudio</h3>
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Código del Grupo:</span> {{ $inscripcione->grupo['codigo'] }}
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Nombre del grupo:</span> {{ $inscripcione->grupo['nombre'] }}
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Nivel:</span> {{"Cod: " . $inscripcione->grupo['nivel']->codigo . " - " .$inscripcione->grupo['nivel']->nombre }}
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary"> <b>Profesor: </b> </span> {{ $inscripcione->grupo['profesor']->nombre }} <br>
                              <span class="text-primary">C.I.:</span> {{ $inscripcione->grupo['profesor']->nacionalidad . "-" . $inscripcione->grupo['profesor']->cedula }} <br>
                              <span class="text-primary">Edad:</span> {{ $inscripcione->grupo['profesor']->edad }} Años <br>
                              <span class="text-primary">Teléfono:</span> {{ $inscripcione->grupo['profesor']->telefono }} <br>
                              <span class="text-primary">Correo:</span> {{ $inscripcione->grupo['profesor']->correo }}
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary"> <b> Horario de clase: </b></span> <br>
                              <span class="text-primary">Días:</span> {{ $inscripcione->grupo['dias'] }} <br>
                              <span class="text-primary">Horas:</span> 
                              De {{ isset($inscripcione->grupo['hora_inicio']) ? date_format(date_create($inscripcione->grupo['hora_inicio']), 'h:i:a' ) : "" }}
                              Hasta {{ isset($inscripcione->grupo['hora_fin']) ? date_format(date_create($inscripcione->grupo['hora_fin']), 'h:i:a' ): ""  }}
                            </div>

                            <div class="col-md-12 label mt-2"> 
                              <hr>
                              <h3>Plan de pago</h3>
                            </div>

                            <div class="col-md-12 label"> 
                              <span class="text-primary">Plan:</span> {{ $inscripcione->plan->nombre }}
                            </div>

                            <div class="col-md-12 label"> 
                              <div class="card">
                                <div class="card-body">
                                  <h5 class="card-title">Cuotas</h5>
                    
                                  <!-- List group With Icons -->
                                  <ul class="list-group">
                                    @foreach ($inscripcione->cuotas as $cuota)
                                    <li class="list-group-item">
                                      <i class="{{ $cuota->estatus == 1 ? "bi bi-check-circle me-1 text-success" : "bi bi-exclamation-octagon me-1 text-warning" }}"></i> 
                                      <a href="{{ $cuota->estatus == 1 ? "/pagos" : "/pagos/$inscripcione->cedula_estudiante/$inscripcione->codigo" }}" target="_self">
                                        <span class="{{ $cuota->estatus == 1 ? "text-success" : "text-danger" }}"> 
                                          {{ isset($cuota->fecha) ? date_format(date_create($cuota->fecha), "d-m-Y") : ""}} {{ " | " . $cuota->cuota}}
                                        </span>
                                      </a>
                                    </li>
                                    @endforeach
                                  </ul><!-- End List group With Icons -->
                    
                                </div>
                              </div>
                            </div>

                          @endforeach
                        @else
                          <span class="text-danger">{{ "No tiene inscripcione asignado" }}</span>
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