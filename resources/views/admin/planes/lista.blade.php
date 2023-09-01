@extends('layouts.app')

@section('title', 'Lista de Planes')

@section('content')

    {{-- @isset($respuesta)
        @include('partials.alert')
    @endisset --}}
    <div id="alert"></div>

    <section class="section">
        <div class="row">



            <div class="col-sm-12">
                <h2> Lista de Planes de pago </h2>
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
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Cantidad de cuotas</th>
                                    <th scope="col">Plazo de días</th>
                                    <th scope="col">Descripcion del plan</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 1; @endphp
                                @foreach ($planes as $plane)
                                    <tr>
                                        <th scope="row">{{ $contador }}</th>
                                        <td>{{ $plane->codigo }}</td>
                                        <td>{{ $plane->nombre }}</td>
                                        <td>{{ $plane->cantidad_cuotas }}</td>
                                        <td>{{ $plane->plazo }} Dias</td>
                                        <td>{{ $plane->descripcion }}</td>

                                        <td>

                                            <a href="/planes/{{ $plane->id }}/edit" target="_self">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="#" id="planes/{{ $plane->id }}/delete" target="_self">

                                                @include('admin.planes.partials.modal')

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
