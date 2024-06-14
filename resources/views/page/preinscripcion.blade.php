@extends('layouts.page')


@section('content')
    <!-----form---->
    @if( session('mensaje') )
        @include('partials.alertTail')
    @endif
    
    <div class=" mt-[6em] w-[80%] m-auto">
        <h1
            class="text-[#bc1e2b] text-center text-[26px]  sm:text-[34px] md:text-[37px]  lg:text-[40px] 2xl:text-[48px] font-semibold border-b-2 border-[#BC1E2B]">
            Registro de preinscripción
        </h1>
        <p
            class="mt-3 text-center font-semibold text-[16px]  sm:text-[18px] md:text-[22px]  lg:text-[24px] 2xl:text-[26px] mb-[3%] ">
            {{ count($nivelSolicitado) ? "Selecciona un plan de pago" : "Seleccione el nivel a cursar" }}
        </p>

        @if (count($nivelSolicitado))
            {{-- INFORMACION DEL CURSO SELECCIONADO --}}
            <div class="w-[]">
                <div class="text-sm font-semibold cursor-pointer text-green-500  tracking-wider hover:text-[#e9b02f]">
                    Curso seleccionado
                </div>
                <div
                    class="rounded-xl overflow-hidden flex shadow border-gray-300 hover:shadow-[#e9b02f] hover:shadow-sm max-w-sm bg-white  h-[120px] mb-[5%] ">
                    <div class="lg:flex flex w-5/12 p-2 rounded-[20px]">
                        <img src="{{ asset($nivelSolicitado[0]->imagen) }}"
                            class="rounded-[15px] object-contain w-full h-full" />
                    </div>
                    <div class="w-7/12 pl-3 p-3 text-text1 flex flex-col justify-center">
                        <p class="text-base mb-2 font-bold truncate">{{ $nivelSolicitado[0]->nombre }}</p>
                        <div class="text-xs text-primary mb-2">
                            <span class="font-bold tracking-wide text-sm text-[#bc1e2b]">Precio del curso:
                                {{ $nivelSolicitado[0]->precio }} $ </span>
                        </div>
                        <span
                            class=" cursor-pointer font-semibold tracking-wide text-[12px] text-black hover:text-[#e9b02f]">
                            Lapso del curso: {{ $nivelSolicitado[0]->duracion . ' ' . $nivelSolicitado[0]->tipo_duracion }}
                        </span>


                    </div>

                </div>
            </div>

            <div class="text-sm font-semibold cursor-pointer text-text2 tracking-wider hover:text-[#e9b02f]">
                Seleccione un plan de pago
            </div>

            <div class="grid md:grid-cols-4 md:gap-4 xs:grid-cols-12 xs:gap-12">
                @foreach ($planes as $plan)
                <div class="m-2 rounded-md border border-[#BC1E2B] p-8 text-center shadow-md">
                    <div class="button-text mx-auto flex h-12 w-12 items-center justify-center rounded-md border "
                        style="background-image: linear-gradient(117deg, rgba(255,192,57,1) 0%, rgba(244,176,31,1) 64%, rgba(227,154,0,1) 100%);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tools"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 21h4l13 -13a1.5 1.5 0 0 0 -4 -4l-13 13v4"></path>
                            <line x1="14.5" y1="5.5" x2="18.5" y2="9.5"></line>
                            <polyline points="12 8 7 3 3 7 8 12"></polyline>
                            <line x1="7" y1="8" x2="5.5" y2="9.5"></line>
                            <polyline points="16 12 21 17 17 21 12 16"></polyline>
                            <line x1="16" y1="17" x2="14.5" y2="18.5"></line>
                        </svg>
                    </div>
                    <h3 class="mt-2 text-black font-bold">
                        {{ $plan->nombre}}:
                    </h3>

                    <h4 class="text-green-500 font-bold text-lg">
                        {{ $plan->porcentaje_descuento }}% de descuento
                    </h4>
                    <h4 class="text-gray-500 font-normal text-lg">
                        Cantidad de estudiante a inscribir: {{ $plan->cantidad_estudiantes }}
                    </h4>
                 
                    <h4 class="text-red-500 font-normal text-lg">
                        Monto total: {{ $nivelSolicitado[0]->precio }} $
                    </h4>

                    <h4 class="text-gray-500 font-normal text-lg">
                        Monto a pagar por estudiante
                    </h4>
                    <h4 class="text-green-500 font-normal text-3xl">
                        {{ ($nivelSolicitado[0]->precio -($nivelSolicitado[0]->precio * ($plan->porcentaje_descuento / 100))) }} $
                    </h4>



                    <a href="{{ route('page.preinscripcion.estudiante', [ "codigo_nivel" => $nivelSolicitado[0]->codigo, "codigo_plan" => $plan->codigo ]) }}"
                        class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white rounded-lg hover:bg-[#bc1e2bea]  mt-4">
                        <span class="mx-auto text-[90%] flex ">
                            Obtener plan
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </span>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            {{-- INPUT PARA SELECCIONAR CURSO EN CASO DE NO HABER SELECIONADO UNO --}}
            <form action="{{route('page.preinscripcion.index')}}" method="post">
            @csrf
            @method('GET')
                <div class="mb-6">
                    <label for="select_cursos"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white ">Cursos</label>
                    <select id="select_cursos" name="codigo_nivel"
                        class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option selected disabled value="">Seleccione el curso</option>
                        @foreach ($niveles as $nivel)
                            <option value="{{ $nivel->codigo }}">{{ $nivel->nombre }} - Inversión: {{ $nivel->precio }}$
                            </option>
                        @endforeach

                    </select>
                </div>
            </form>
        @endif




    </div>


    <script src="{{ asset('assets/js/master.js') }}" defer></script>
    <script src="{{ asset('assets/js/preinscripciones/index.js') }}" defer></script>
@endsection
