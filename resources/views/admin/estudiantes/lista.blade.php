@extends('layouts.app')

@section('title', 'Lista de Estudiantes')

@section('content')
    <div id="alert"></div>
    <section class="section">
        <div class="row">

            <div class="col-xs-12 col-sm-8 ">
                <h2>Lista de Estudiantes</h2>
            </div>
            <div class="col-xs-12 col-sm-4 text-end mb-2">
                <a href="{{ route('admin.estudiantes.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus"></i>
                    Registrar nuevo estudiante
                </a>
            </div>



            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <form action="{{ route('admin.estudiantes.index') }}" method="GET" id="filtro">
                            @csrf
                            @method('GET')
                            <div class="input-group mb-3">

                                <div class="form-floating ">
                                    <input type="text" class="form-control" id="floatingInput" name="filtro"
                                        value="{{ $request->filtro ?? '' }}" placeholder="Ingrese código, rif o nombre"
                                        required>
                                    <label for="floatingInput">Buscar</label>
                                </div>

                                <div class="form-floating">
                                    <select class="form-select" id="floatingSelect" name="campo"
                                        aria-label="Floating label select example">
                                        @if ($request->campo)
                                            <option value="{{ $request->campo }}" selected>
                                                @switch($request->campo)
                                                    @case('cedula')
                                                        Por cédula
                                                    @break

                                                    @case('nombre')
                                                        Por nombre
                                                    @break

                                                    @default
                                                @endswitch
                                            </option>
                                        @else
                                            <option value="cedula">Por cédula</option>
                                        @endif

                                        <option value="cedula">Por cédula</option>
                                        <option value="nombre">Por Nombre</option>
                                        
                                    </select>
                                    <label for="floatingSelect">Seleccione el tipo de filtro</label>
                                </div>


                                <button type="submit" class="btn btn-primary input-group-text"
                                    id="inputGroup-sizing-default">
                                    <i class="bi bi-search"></i>
                                </button>

                            </div>
                        </form>
                    </div>
                    <div class="card-body table-responsive">

                        <!-- Table with stripped rows -->

                        <table class="table">
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
                                        <th scope="row">{{ $estudiante->id }}</th>
                                        <td>{{ $estudiante->nombre }}</td>
                                        <td>{{ number_format($estudiante->cedula, 0, ',', '.') }}</td>
                                        <td>{{ '(' . substr($estudiante['telefono'], 0, 4) . ')' . ' ' . substr($estudiante['telefono'], 5, 3) . '-' . substr($estudiante['telefono'], 6, 4) }}
                                        </td>
                                        <td>{{ $estudiante->correo }}</td>

                                        <td>

                                            {{-- Boton modal de info del estudiante --}}
                                            @include('admin.estudiantes.partials.modaldialog')

                                            {{-- Boton editar --}}
                                            <a href="{{ route('admin.estudiantes.edit', $estudiante->id) }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            {{-- Boton eliminar --}}
                                            @include('admin.estudiantes.partials.modal')


                                        </td>
                                    </tr>
                                    @php $contador++; @endphp
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2">
                                        Total de resultados: {{ $estudiantes->count() }}
                                    </td>
                                    <td colspan="4">
                                        {{ $estudiantes->appends(['filtro' => $request->filtro, 'campo' => $request->campo])->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>


                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>



        </div>
    </section>





@endsection
