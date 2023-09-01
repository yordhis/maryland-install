@extends('layouts.app')

@section('title', 'Lista de Grupos de estudio')

@section('content')

    @isset($respuesta)
        @include('partials.alert')
    @endisset
    <div id="alert"></div>

    <section class="section">
        <div class="row">

            <div class="col-sm-12">
                <h2> Lista de Grupos de Estudio </h2>
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
                                    <th scope="col">Nombre del grupo</th>
                                    <th scope="col">Profesor</th>
                                    <th scope="col">Nivel de estudio</th>
                                    <th scope="col">Matricula</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 1; @endphp
                                @foreach ($grupos as $grupo)
                                    <tr>
                                        <th scope="row">{{ $contador }}</th>
                                        <td>{{ $grupo->codigo }}</td>
                                        <td>{{ $grupo->nombre }}</td>
                                        <td>{{ $grupo->profesor['nombre'] }}</td>
                                        <td>{{ $grupo->nivel['nombre'] }}</td>
                                        <td>{{ $grupo->matricula }}</td>


                                        <td>

                                            <a href="/grupos/{{ $grupo->id }}" target="_self">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="/grupos/{{ $grupo->id }}/edit" target="_self">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            {{-- Boton de eliminar  --}}
                                            @include('admin.grupos.partials.modal')
                            
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
