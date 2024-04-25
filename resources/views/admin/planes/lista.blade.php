@extends('layouts.app')

@section('title', 'Lista de Planes')

@section('content')

    @if( session('mensaje') )
        @include('partials.alert')
    @endif
    <div id="alert"></div>

    <section class="section">
        <div class="row">



            <div class="col-sm-6 col-xs-12">
                <h2> Lista de Planes de pago </h2>
            </div>
            <div class="col-sm-6 col-xs-12">
                <form action="{{ route('admin.planes.index') }}" method="post">
                @csrf
                @method('get')
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
                            <th scope="col">Código</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad de cuotas</th>
                            <th scope="col">Plazo de días</th>
                            <th scope="col">Descripcion del plan</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
               
                        @foreach ($planes as $plane)
                            <tr>
                                <th scope="row">{{ $plane->id }}</th>
                                <td>{{ $plane->codigo }}</td>
                                <td>{{ $plane->nombre }}</td>
                                <td>{{ $plane->cantidad_cuotas }}</td>
                                <td>{{ $plane->plazo }} Dias</td>
                                <td class="text-break">{{ $plane->descripcion }}</td>

                                <td>

                                    <a href="{{ route('admin.planes.edit', $plane->id) }}">
                                        <i class="bi bi-pencil"></i>
                                    </a>


                                    @include('admin.planes.partials.modal')


                                </td>
                            </tr>
                           
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>

                            <td colspan="7" class="text-center table-secondary">
                                Total de planes: {{ $planes->total() }} | 
                                <a href="{{ route('admin.planes.index') }}"
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
                {{ $planes->appends(['filtro'=> $request->filtro])->links() }}
            </div>

            <div class="col-sm-6 col-xs-12 text-end">
                @include('admin.planes.partials.modaldialog')
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
