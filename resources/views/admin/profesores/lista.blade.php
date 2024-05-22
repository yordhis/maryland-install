@extends('layouts.app')

@section('title', 'Lista de profesores')

@section('content')

    @if( session('mensaje') )
        @include('partials.alert')
    @endif
    <div id="alert"></div>

    <section class="section">
        <div class="row">



            <div class="col-sm-6 col-xs-12">
                <h2> Lista de profesores</h2>
            </div>
            <div class="col-sm-6 col-xs-12">
                <form action="{{ route('admin.profesores.index') }}" method="post">
                @csrf
                @method('GET')
                <div class="input-group mb-3">
                    <input type="text" class="form-control" 
                    name="filtro"
                    placeholder="Buscar" 
                    aria-label="Filtrar" 
                    aria-describedby="button-addon2" required>
                    <button class="btn btn-primary" type="submit" id="button-addon2">
                        <i class="bi bi-search"></i>
                    </button>
                  </div>
                </form>
            </div>

            <div class="col-lg-12 table-responsive">
                <!-- Table with stripped rows -->

                <table class="table table-hover  bg-white mt-2">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cédula</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Grupos</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
               
                        @foreach ($profesores as $profesor)
                            <tr>
                                <th scope="row">{{ $profesor->id }}</th>
                                <td>{{ $profesor->nombre }}</td>
                                <td>{{ $profesor->cedula }}</td>
                                <td>{{ $profesor->telefono }}</td>
                                <td>{{ "Asignados " . count($profesor->grupos_estudios) }}</td>
                               

                                <td>
                                    @include('admin.profesores.partials.modalver')
                                    
                                    <a href="{{ route('admin.profesores.edit', $profesor->id) }}">
                                        <i class="bi bi-pencil text-warning"></i>
                                    </a>


                                    @include('admin.profesores.partials.modal')


                                </td>
                            </tr>
                           
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>

                            <td colspan="7" class="text-center table-secondary">
                                Total de profesores: {{ $profesores->total() }} | 
                                <a href="{{ route('admin.profesores.index') }}"
                                   class="text-primary" >
                                    Ver todo
                                </a>
                                <br>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- End Table with stripped rows -->
                <div class="col-sm-6 col-xs-12">
                    {{ $profesores->appends(['filtro'=> $request->filtro])->links() }}
                </div>

            </div>


            <div class="col-12 text-end">
                @include('admin.profesores.partials.modalform')
            </div>
            <div class="col-sm-6 col-xs-12 text-end">
                <br>
                 
                @if ($errors->any())
                    <div class="alert alert-danger text-start">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

       

    </section>


    


@endsection
