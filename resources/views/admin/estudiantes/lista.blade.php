@extends('layouts.app')

@section('title', 'Lista de estudiantes')

@section('content')

    @if (session('mensaje'))
        @include('partials.alert')
    @endif

    <div id="alert"></div>

    <section class="section">
        <div class="row">

            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show text-start" role="alert">
                    <strong>Faltaron datos!</strong> verifique que los datos del estudiante esten correctamente suminitrados en el formulario, vuelva a hacer click en el botón registrar estudiante.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            <div class="col-sm-6 col-xs-12">
                <h2> Lista de estudiantes </h2>
            </div>

            <div class="col-sm-6 col-xs-12">
                <form action="{{ route('admin.estudiantes.index') }}" method="post">
                    @csrf
                    @method('get')
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="filtro" 
                            placeholder="Filtrar (Por cédula o Por nombre)" 
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
                            <th scope="col">Nombres y Apellidos</th>
                            <th scope="col">Cédula</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($estudiantes as $estudiante)
                            <tr>
                                <td scope="row">{{ $estudiante->id }}</td>
                                <td>{{ $estudiante->nombre }}</td>
                                <td>{{ number_format($estudiante->cedula, 0, ',', '.') }}</td>
                                <td>{{ '(' . substr($estudiante['telefono'], 0, 4) . ')' . ' ' . substr($estudiante['telefono'], 5, 3) . '-' . substr($estudiante['telefono'], 6, 4) }}</td>
                                <td>{{ $estudiante->correo }}</td>

                                <td>

                                    {{-- Boton modal de info del estudiante --}}
                                    @include('admin.estudiantes.partials.modaldialog')

                                    {{-- Boton editar --}}
                                    <a href="{{ route('admin.estudiantes.edit', $estudiante->id) }}">
                                        <i class="bi bi-pencil-square fs-4 text-warning"></i>
                                    </a>

                                    {{-- Boton eliminar --}}
                                    @include('admin.estudiantes.partials.modal')
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>

                            <td colspan="7" class="text-center table-secondary">
                                Total de estudiantes: {{ $estudiantes->total() }} | 
                                <a href="{{ route('admin.estudiantes.index') }}"
                                   class="text-primary" >
                                    Ver todo
                                </a>
                                <br>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <!-- End Table with stripped rows -->
                <div class="col-xs-12 col-sm-6 ">
                    {{ $estudiantes->appends(['filtro' => $request->filtro])->links() }}
                </div>

            </div>


            <div class="col-12 text-end">
                    @include('admin.estudiantes.partials.modalFormulario')
            </div>
            <div class="col-sm-6 col-xs-12 text-end">
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
    <script src="{{ asset('assets/js/estudiantes/create.js') }}" defer></script>
    <script src="{{ asset('assets/js/representantes/getRepresentante.js') }}" defer></script>


@endsection
