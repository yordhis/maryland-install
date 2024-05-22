@extends('layouts.app')

@section('title', 'Lista de Profesores')

@section('content')

        <section class="section profile">
            <div class="row">

                <div class="col-sm-12">
                    <h2>Lista de Profesores</h2>
                </div>

                <div id="alert"></div>
                @if (count($profesores))
                    @foreach ($profesores as $profesor)
            
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body profile-card pt-4 d-flex flex-inline align-items-center">
                                    
                                        <div class="col-sm-2">
                                            <img src="{{ asset($profesor['foto']) }}" alt="Foto" class="rounded-circle">
                                        </div>
                                        <div class="col-sm-3">
                                            <p class="text-primary">Profesor</p>
                                            <h2>{{$profesor['nombre']}}</h2>
                                            <h3>{{$profesor['nacionalidad'] . "-" . number_format($profesor['cedula'],0,',','.') }}</h3>
                                            <h6>{{$profesor['edad']}} años</h6>
                                            
                                        </div>
                                        <div class="col-sm-3">
                                            
                                            <p class="text-primary">Contacto</p>
                                            @if ($profesor['telefono'])
                                                <h2>{{
                                                "(".substr( $profesor['telefono'],0,4).")"." ".substr( $profesor['telefono'],5,3)."-".substr( $profesor['telefono'],6,4)
                                                }}</h2>
                                                
                                            @else
                                                <h2>No registrado.</h2>
                                            @endif
                                            <h6>{{ $profesor['correo'] }}</h6>
                                            
                                        </div>
                                        <div class="col-sm-3 ">
                                        
                                                <p class="text-primary">Estatus</p>
                                                <h2 class="{{ $profesor['estatus'] == 1 ? 'text-success' : 'text-warning' }}" >
                                                    {{ $profesor['estatus'] == 1 ? 'Activo' : 'Inactivo' }}
                                                </h2>
                                            
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="social-links mt-2 d-flex flex-column ">
                                                {{-- <a href="/profesores/{{$profesor->id}}" class="twitter text-danger fs-3 mb-3 "><i class="bi bi-trash"></i></a> --}}
                                                @include('admin.profesores.partials.modal')
                                                <a href="{{ route('admin.profesores.edit', $profesor->id ) }}"  class="facebook text-warning fs-3"><i class="bi bi-pencil"></i></a>
                                            </div>
                                        </div>
                                        

                                </div>
                            </div>
                        </div>
        
                    @endforeach
                @else
                    <div class="card p-4 text-center text-danger fs-1">
                        <div class="d-flex justify-content-center">
                            <div class="d-flex flex-column">
                                <p>No hay registros</p>
                                <a href="{{ route('admin.profesores.create') }}" 
                                class="btn btn-primary">
                                    <i class="bi bi-person-plus fs-4 p-2"></i>
                                    Crear Profesor
                                </a>
                            </div>

                        </div>
                    </div>
                @endif

            </div>
        </section>

    @endsection