@extends('layouts.app')

@section('title', 'Lista de Asignacion de notas')

@section('content')

    @isset($respuesta['activo'])
        @include('partials.alert')  
    @endisset

    <div id="alert"></div>

    <section class="section">
        <div class="row">

           

            <div class="col-sm-12">
                <h2> Lista de Asignación de Notas</h2>
            </div>

            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body table-responsive">
                    
                        <!-- Table with stripped rows -->
                        
                            <table class="table datatable ">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">N° Inscripción</th>
                                        <th scope="col">Estudiante</th>
                                        <th scope="col">Nivel de Estudio</th>
                                        <th scope="col">Grupo de Estudio</th>
                                        <th scope="col">Fecha de C. del curso</th>
                                        <th scope="col">Estatus de incripción</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $contador = 1; @endphp
                                    @foreach ($inscripciones as $inscripcione)
                                        <tr>
                                            <th scope="row">{{ $contador }}</th>
                                            <td>{{ $inscripcione->codigo }}</td>
                                            <td>
                                                {{ $inscripcione->estudiante->nombre }} <br>
                                                C.I.:{{ number_format($inscripcione->estudiante->cedula, 0, ',','.') }}
                                            </td>
                                            <td>{{ $inscripcione->grupo['nivel']->nombre }}</td>
                                            <td>{{ $inscripcione->grupo['nombre']}}</td>
                                             <td>{{ $inscripcione->grupo['fecha_fin'] }}</td>
                                            <td>
                                                {{ $inscripcione->estatusText }} <br>
                                                Nota: {{ $inscripcione->nota ?? 0 }}
                                            </td>  
                                       
    
                                            <td>
                                                <a href="/inscripciones/{{$inscripcione->id}}" target="_self">
                                                    <i class="bi bi-eye fs-3"></i>
                                                </a>
                                                {{-- <a href="/inscripciones/{{$inscripcione->id}}/edit" target="_self">
                                                    <i class="bi bi-pencil fs-3 text-warning"></i>
                                                </a> --}}

                                                @include('admin.inscripciones.partials.modal')

                                                @include('admin.inscripciones.partials.modalEliminar')
                                                    
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
