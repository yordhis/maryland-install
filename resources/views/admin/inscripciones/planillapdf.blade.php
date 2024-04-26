<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planilla de inscripción </title>
    <link href="assets/css/fuente.css">

    {{-- SEO --}}
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo-img-circulo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo-img-circulo.png') }}" rel="apple-touch-icon">



    <!-- Template Main CSS File -->
    {{-- <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/css/personalizado.css') }}" rel="stylesheet">

</head>

<body>
    <header class="caja">
        <img src="{{ asset('assets/img/header_planilla.png') }}" alt="cabezera de planilla de inscripcion">
        <span id="codigo"> {{ $inscripciones[0]->codigo ?? '' }} </span>
        <span id="fecha"> {{ $inscripciones[0]->fecha ?? '' }} </span>
    </header>

    <table>
        <thead>
            <tr>
                <td colspan="4" class="text-title bg-gris"><b>DATOS PERSONALES</b></td>
            </tr>
        </thead>
        <tbody>
            {{-- DATOS DE ESTUDIANTES --}}
            @foreach ($estudiantes as $key => $estudiante)
                <tr>
                    <td colspan="4" class="bg-gris">
                        <b>{{$key + 1}} ESTUDIANTE:</b> {{ $estudiante->nombre }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>C.I.:</b> {{ $estudiante->nacionalidad . '-' . $estudiante->cedulaFormateada }}
                    </td>
                    <td colspan="2">
                        <b>F. NACIMIENTO:</b> {{  date_format( date_create( $estudiante->nacimiento ), 'd/m/Y' ) }}
                    </td>
                    <td>
                        <b>EDAD:</b> {{ $estudiante->edad . ' AÑOS' }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>TELÉFONO:</b> {{ $estudiante->telefono }}
                    </td>
                    <td colspan="3">
                        <b>CORREO:</b> {{ $estudiante->correo }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <b>DIFICULTAD DE APRENDIZAJE:</b>
                        @foreach ($estudiante->dificultades as $dificultad)
                            @if ($dificultad->estatus)
                                <input class="form-check-input" type="checkbox" checked disabled id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $dificultad->dificultad }}
                                </label>
                            @else
                                <input class="form-check-input" type="checkbox" disabled id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $dificultad->dificultad }}
                                </label>
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <b>OCUPACIÓN:</b> {{ $estudiante->ocupacion }}
                    </td>
                    <td>
                        <b>GRADO DE ESTUDIO:</b> {{ $estudiante->grado }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <b>DIRECCIÓN:</b> {{ $estudiante->direccion }}
                    </td>
                </tr>
            @endforeach

            {{-- DATOS DE REPRESENTANTE --}}
            @if (count($estudiantes[0]->representantes))
                <tr>
                    <td colspan="4" class="text-title bg-gris"><b>DATOS DEL REPRESENTANTE</b></td>
                </tr>
                <tr>
                    <td><b>NOMBRE Y APELLIDO:</b> {{ $estudiantes[0]->representantes[0]->representante->nombre }}</td>
                    <td><b>C.I.:</b> {{ $estudiantes[0]->representantes[0]->representante->cedula }}</td>
                    <td colspan="2"><b>EDAD:</b> {{ $estudiantes[0]->representantes[0]->representante->edad . ' AÑOS' }}</td>
                </tr>
                <tr>
                    <td><b>TELÉFONO:</b> {{ $estudiantes[0]->representantes[0]->representante->telefono }}</td>
                    <td><b>CORREO:</b> {{ $estudiantes[0]->representantes[0]->representante->correo }}</td>
                    <td colspan="2"><b>OCUPACIÓN:</b> {{ $estudiantes[0]->representantes[0]->representante->ocupacion }}</td>
                </tr>
                <tr>
                    <td colspan="4"><b>DIRECCIÓN:</b> {{ $estudiantes[0]->representantes[0]->representante->direccion }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="4" class="text-title bg-gris"><b>PLAN DE ESTUDIO</b></td>
            </tr>
            <tr>
                <td><b>NIVEL O CURSO:</b> {{ $inscripciones[0]->nivel_nombre }}</td>
                <td><b>GRUPO DE ESTUDIO:</b> {{ $inscripciones[0]->grupo_nombre }}</td>
                <td><b>FECHA DE INICIO:</b> {{ $inscripciones[0]->fecha_init  }}</td>
                <td><b>FECHA DE CULMINACIÓN:</b> {{ $inscripciones[0]->fecha_end }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <b>HORARIO:</b>
                    {{ $inscripciones[0]->hora_init . ' - ' . $inscripciones[0]->hora_end }}
                    <b> DÍAS:</b> {{ $inscripciones[0]->grupo_dias }}
                </td>
                <td colspan="2"><b>LIBRO:</b> {{ $inscripciones[0]->nivel_libro }}</td>
            </tr>
            <tr>
                <td colspan="4"><b>PROFESOR:</b> {{ $inscripciones[0]->grupo_profesor_nombre }}</td>
            </tr>

            <tr>
                <td colspan="4" class="text-title bg-gris"><b>PLAN DE PAGO</b></td>
            </tr>
            <tr>
                <td ><b>PLAN:</b> {{ $inscripciones[0]->plan_nombre }} </td>
                <td colspan="3"><b>DESCRIPCIÓN DEL PLAN:</b> {{ $inscripciones[0]->plan_descripcion }} </td>

            </tr>
            <tr>
                <td class="text-danger"><b>VALOR:</b> {{ $inscripciones[0]->total }} $</td>
                <td><b>CANTIDAD DE CUOTAS:</b> {{ $inscripciones[0]->plan_cantidad_cuotas }} </td>
                <td colspan="2"><b>PLAZO POR CUOTA:</b> {{ $inscripciones[0]->plan_plazo . ' DÍAS' }} </td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-title bg-gris"><b>INFORMACIÓN EXTRA</b></td>
            </tr>
            <tr>
                <td>
                    <b>¿PROMOCIÓN?</b><br>
                    @if ($inscripciones[0]->extras[0] == 'si')
                        <input class="form-check-input" type="checkbox" checked disabled id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            SI
                        </label>
                        <input class="form-check-input" type="checkbox" disabled id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            NO
                        </label>
                    @else
                        <input class="form-check-input" type="checkbox" disabled id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            SI
                        </label>
                        <input class="form-check-input" type="checkbox" checked disabled id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            NO
                        </label>
                    @endif
                </td>
                <td colspan="3">
                    <b>EXPLIQUE:</b> {{$inscripciones[0]->extras[1]}}
                </td>
            </tr>
            <tr>
                <td>
                    <b>¿SE ENTREGO MATERIAL?</b><br>
                    @if ($inscripciones[0]->extras[2] == 'si')
                        <input class="form-check-input" type="checkbox" checked disabled id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            SI
                        </label>
                        <input class="form-check-input" type="checkbox" disabled id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            NO
                        </label>
                    @else
                        <input class="form-check-input" type="checkbox" disabled id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            SI
                        </label>
                        <input class="form-check-input" type="checkbox" checked disabled id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            NO
                        </label>
                    @endif
                </td>
                <td colspan="3">
                    <b>¿CÓMO SE ENTERÓ DEL CURSO?:</b> {{$inscripciones[0]->extras[3]}}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <b>OBSERVACIÓN:</b> {{$inscripciones[0]->extras[4]}}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <b>NOTA:</b> {{ $inscripciones[0]->nota ?? "En curso"}}
                </td>
            </tr>
        </tfoot>
    </table>

    <footer>
        <img src="{{ asset('assets/img/footer_planilla.png') }}" alt="pie de planilla de inscripcion">

    </footer>
</body>

</html>
