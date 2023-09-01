@extends('layouts.app')

@section('title', 'Lista de Profesores')

@section('content')

    @isset($respuesta)
    @include('partials.alert')  
    @endisset
    <div id="alert"></div>
    
    <section class="section">
        <div class="row">

            <div class="col-sm-12">
                <h2>Lista de Nideveles de estudio</h2>
            </div>



            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body table-responsive">
                    
                        <!-- Table with stripped rows -->
                        
                            <table class="table datatable ">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Código</th>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">precio</th>
                                        <th scope="col">libro</th>
                                        <th scope="col">Duración del nivel</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $contador = 1; @endphp
                                    @foreach ($niveles as $nivele)
                                        <tr>
                                            <th scope="row">{{$contador}}</th>
                                            <td>{{$nivele->codigo}}</td>
                                            <td>{{$nivele->nombre}}</td>
                                            <td>{{$nivele->precio}}$</td>
                                            <td>{{$nivele->libro}}</td>
                                            <td>{{$nivele->duracion}} {{$nivele->tipo_duracion}}</td>
    
                                            <td>
                                              
                                                <a href="/niveles/{{$nivele->id}}/edit" target="_self">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="#" id="niveles/{{$nivele->id}}/delete" target="_self">
                                                        
                                                    @include('admin.niveles.partials.modal')
                                                    
                                                </a>
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
