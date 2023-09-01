@extends('layouts.app')

@section('title', 'Lista de Estudiantes')

@section('content')
    <div id="alert"></div>
    <section class="section">
        <div class="row">

            <div class="col-sm-12">
                <h2>Lista de Estudiantes</h2>
            </div>



            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body table-responsive">
                    
                        <!-- Table with stripped rows -->
                        
                            <table class="table datatable ">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombres y Apellidos</th>
                                        <th scope="col">Cédula</th>
                                        <th scope="col">Teléfono</th>
                                        <th scope="col">Correo</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $contador = 1; @endphp
                                    @foreach ($estudiantes as $estudiante)
                                        <tr>
                                            <th scope="row">{{$contador}}</th>
                                            <td>{{$estudiante->nombre}}</td>
                                            <td>{{ number_format($estudiante->cedula,0,',','.') }}</td>
                                            <td>{{
                                           
                                            "(".substr( $estudiante['telefono'],0,4).")"." ".substr( $estudiante['telefono'],5,3)."-".substr( $estudiante['telefono'],6,4)
                                            }}</td>
                                            <td>{{$estudiante->correo}}</td>
    
                                            <td>
                                                <a href="/estudiantes/{{$estudiante->id}}" target="_self">
                                                    @include('admin.estudiantes.partials.modaldialog')
                                                </a>
                                                <a href="/estudiantes/{{$estudiante->id}}/edit" target="_self">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                        
                                                @include('admin.estudiantes.partials.modal')
                                                    
                                                
                                            </td>
                                        </tr>
                                        @php $contador++; @endphp
                                    @endforeach
                                    
                                </tbody>
                            </table>
                     
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>



        </div>
    </section>

    
  
 

@endsection
