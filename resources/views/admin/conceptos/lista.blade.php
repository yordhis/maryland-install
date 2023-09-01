@extends('layouts.app')

@section('title', 'Lista de Conceptos de Pago')

@section('content')
    @isset($respuesta)
        @include('partials.alert')
    @endisset
    <div id="alert"></div>

    <section class="section">
        <div class="row">


            <div class="col-sm-12">
                <h2>Lista de Conceptos de Pago</h2>
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
                                    <th scope="col">Descripción de concepto de pago</th>
                                    <th scope="col">Estatus</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 1; @endphp
                                @foreach ($conceptos as $concepto)
                                    <tr>
                                        <th scope="row">{{ $contador }}</th>
                                        <td>{{ $concepto->codigo }}</td>
                                        <td>{{ $concepto->descripcion }}</td>
                                        <td>{{ $concepto->estatus }}</td>
                                        <td>

                                            <a href="/conceptos/{{ $concepto->id }}/edit" target="_self">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="#" id="conceptos/{{ $concepto->id }}/delete" target="_self">

                                                @include('admin.conceptos.partials.modal')

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
