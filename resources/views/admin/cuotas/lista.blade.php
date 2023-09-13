@extends('layouts.app')

@section('title', 'Lista de Cuotas')

@section('content')

    <section class="section">
        <div class="row">

            <div class="col-sm-12">
                <h2>Lista de Cuotas Atrasadas</h2>
            </div>



            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body table-responsive">
                    
                        <!-- Table with stripped rows -->
                        
                            <table class="table datatable ">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Estudiante</th>
                                        <th scope="col">Datos de contacto</th>
                                       
                                        <th scope="col">Fecha de pago</th>
                                        <th scope="col">Monto de Cuota atrasada</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $contador = 1; @endphp
                                    @foreach ($cuotas as $cuota)
                                        <tr>
                                            <th scope="row">{{ $contador }}</th>
                                            <td>
                                                {{ $cuota->estudiante->nombre ?? 'Nombre no registrado' }} <br>
                                                {{ number_format($cuota->estudiante->cedula, 0,',', '.') ?? 'Problema con la cédula' }}
                                            </td>
                                            <td>
                                                {{ substr($cuota->estudiante->telefono,0,4)  ?? 'No poseé N° telefono'}} -
                                                {{ substr($cuota->estudiante->telefono,4, 10) ?? '' }}
                                                 <br>
                                                {{ $cuota->estudiante->correo ?? 'No tiene correo registrado' }}
                                            </td>
                                            
                                            <td>{{ $cuota->fecha ?? 'Sin fecha'}}</td>
                                            <td>{{ $cuota->cuota ?? 'Sin monto'}}</td>
    
                                            <td>
                                              
                                                <a href="/pagos/{{$cuota->estudiante->cedula ?? '0000000'}}/estudiante" target="_self">
                                                    <i class="bi bi-paypal fs-3"></i>
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
