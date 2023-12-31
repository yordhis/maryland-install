@extends('layouts.app')

@section('title', 'Lista de Profesores')

@section('content')

        <section class="section profile">
            <div class="row">

                <div class="col-sm-12">
                    <h2>Lista de Profesores</h2>
                </div>

                @foreach ($profesores as $profesor)
        
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body profile-card pt-4 d-flex flex-inline align-items-center">
                                
                                    <div class="col-sm-2">
                                        <img src="{{$profesor['foto']}}" alt="Profile" class="rounded-circle">
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="text-primary">Profesor</p>
                                        <h2>{{$profesor['nombre']}}</h2>
                                        <h3>{{$profesor['nacionalidad'] . "-" . number_format($profesor['cedula'],0,',','.') }}</h3>
                                        <h6>{{$profesor['edad']}} años</h6>
                                        
                                    </div>
                                    <div class="col-sm-3">
                                        
                                        <p class="text-primary">Contacto</p>
                                        <h2>{{
                                        "(".substr( $profesor['telefono'],0,4).")"." ".substr( $profesor['telefono'],5,3)."-".substr( $profesor['telefono'],6,4)
                                        }}</h2>
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
                                            <a href="/profesores/{{$profesor->id}}/edit" target="_self" class="facebook text-warning fs-3"><i class="bi bi-pencil"></i></a>
                                        </div>
                                    </div>
                                    

                            </div>
                        </div>
                    </div>
    
                @endforeach

            </div>
        </section>

    @endsection