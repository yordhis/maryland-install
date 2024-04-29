@extends('layouts.app')

@section('title', 'Lista de grupos')

@section('content')

    @if (session('mensaje'))
        @include('partials.alert')
    @endif
    <div id="alert"></div>

    <section class="section">
        <div class="row">



            <div class="col-sm-6 col-xs-12">
                <h2> Lista de grupos de estudio </h2>
            </div>
            <div class="col-sm-6 col-xs-12">
                <form action="{{ route('admin.grupos.index') }}" method="post">
                    @csrf
                    @method('get')
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="filtro" 
                            placeholder="Filtrar (Por cédula, Por nombre del grupo y codigo de grupo)" 
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
                            <th scope="col">Código</th>
                            <th scope="col">Grupo</th>
                            <th scope="col">Profesor</th>
                            <th scope="col">Nivel</th>
                            <th scope="col">Matricula</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($grupos as $grupo)
                            <tr>
                                <th scope="row">{{ $grupo->id }}</th>
                                <td>{{ $grupo->codigo }}</td>
                                <td>{{ $grupo->nombre }}</td>
                                <td>{!! 
                                    $grupo->profesor_nombre . "<br>"
                                    . "C.I.:" . $grupo->profesor_cedula 
                                
                                !!}
                                </td>
                                <td>{{ $grupo->nivel_nombre }} </td>
                                <td>{{ $grupo->matricula }} </td>
                                

                                <td>
                                  
                                    @include('admin.grupos.partials.modalVerGrupo')

                                    <a href="{{ route('admin.grupos.edit', $grupo->id) }}">
                                        <i class="bi bi-pencil fs-3 text-warning"></i>
                                    </a>

                                    @include('admin.grupos.partials.modalimprir')
                                    @include('admin.grupos.partials.modal')


                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>

                            <td colspan="7" class="text-center table-secondary">
                                Total de grupos de estudios: {{ $grupos->total() }} | 
                                <a href="{{ route('admin.grupos.index') }}"
                                   class="text-primary" >
                                    Ver todo
                                </a>
                                <br>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- End Table with stripped rows -->

            </div>

            <div class="col-sm-6 col-xs-12">
                {{ $grupos->appends(['filtro' => $request->filtro])->links() }}
            </div>

            <div class="col-sm-6 col-xs-12 text-end">
                @include('admin.grupos.partials.modalformulario')
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
