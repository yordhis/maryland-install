@extends('layouts.app')

@section('title', 'Lista de Inscripciones')

@section('content')

    @if (session('mensaje'))
        @include('partials.alert')
    @endif

    <div id="alert"></div>

    <section class="section">
        <div class="row">



            <div class="col-sm-6 col-xs-12">
                <h2> Lista de Inscripciones </h2>
            </div>
            <div class="col-sm-6 col-xs-12">
                <form action="{{ route('admin.inscripciones.index') }}" method="post">
                    @csrf
                    @method('get')
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="filtro" placeholder="Buscar" aria-label="Filtrar"
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
                            <th scope="col">Estudiante</th>
                            <th scope="col">Total</th>
                            <th scope="col">Abonado</th>
                            <th scope="col">Pendientes</th>
                            <th scope="col">Proximo pago</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($inscripciones as $inscripcion)
                            <tr>
                                <th scope="row">{{ $inscripcion->id }}</th>
                                <td>{{ $inscripcion->codigo }}</td>
                                <td>
                                    {{ $inscripcion->estudiante_nombre ?? 'Sin nombre' }} <br>
                                    C.I.:{{ number_format($inscripcion->cedula_estudiante, 0, ',', '.') }}
                                </td>
                                <td class="fs-5 table-info">{{ number_format($inscripcion->total, 2, ',', '.') }} $</td>
                                <td class="fs-5 table-success">{{ number_format($inscripcion->abono, 2, ',', '.') }} $</td>
                                <td class="fs-5 table-danger">
                                    {{ number_format($inscripcion->total - $inscripcion->abono, 2, ',', '.') }} $</td>
                                <td class="fs-5">
                                    @if ($inscripcion->proxima_fecha_pago == 'PAGADO')
                                        <i class='bi bi-check2-square text-success fs-4'></i>
                                        {{ $inscripcion->proxima_fecha_pago }}
                                    @else
                                        @include('admin.inscripciones.partials.modalcuotas')
                                    @endif
                                </td>

                                <td>

                                    @if ($inscripcion->proxima_fecha_pago != 'PAGADO')
                                        @include('admin.inscripciones.partials.modalpagar')
                                    @endif

                                
                                    @include('admin.inscripciones.partials.modalimprir')
                                    @include('admin.inscripciones.partials.modalEliminar')
                                    @include('admin.inscripciones.partials.modal')


                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>

                            <td colspan="8" class="text-center table-secondary">
                                Total de inscripciones: {{ $inscripciones->total() }} | 
                                <a href="{{ route('admin.inscripciones.index') }}"
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
                {{ $inscripciones->appends(['filtro' => $request->filtro])->links() }}
            </div>

            <div class="col-sm-6 col-xs-12 text-end">
                <a href="{{ route('admin.inscripciones.createEstudiante') }}" class="btn btn-primary">Procesar
                    inscripción</a>
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


    <script src="{{ asset('assets/js/master.js') }}" defer></script>
    <script src="{{ asset('assets/js/pagos/create.js') }}" defer></script>
    <script src="{{ asset('assets/js/inscripciones/lista.js') }}" defer></script>


@endsection
