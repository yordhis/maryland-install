@extends('layouts.page')


@section('content')
    <!-----form---->
    <div class=" mt-[6em] w-[80%] m-auto">
        <h1
            class="text-[#bc1e2b] text-center text-[26px]  sm:text-[34px] md:text-[37px]  lg:text-[40px] 2xl:text-[48px] font-semibold border-b-2 border-[#BC1E2B]">
            Registro de preinscripción
        </h1>
        <p
            class="mt-3 text-center font-semibold text-[16px]  sm:text-[18px] md:text-[22px]  lg:text-[24px] 2xl:text-[26px] mb-[3%] ">
            Haste parte de la Académia de ingles Maryland</p>
        <div class="w-[]">

            {{-- <div
                class="rounded-xl overflow-hidden flex shadow border-gray-300 hover:shadow-[#e9b02f] hover:shadow-sm max-w-sm bg-white  h-[120px] mb-[5%] ">
                <div class="lg:flex flex w-5/12 p-2 rounded-[20px]">
                    <img src="../src/images/intermediate1.jpg" class="rounded-[15px] object-contain w-full h-full" />
                </div>
                <div class="w-7/12 pl-3 p-3 text-text1 flex flex-col justify-center">
                    <p class="text-base mb-2 font-bold truncate">Adolescentes y Adultos</p>
                    <div class="text-xs text-primary mb-2">

                        <span class="font-bold tracking-wide text-sm text-[#bc1e2b]">Plan Individual</span> <span
                            class="ml-2 cursor-pointer font-semibold tracking-wide text-[12px] text-black hover:text-[#e9b02f]">Cambiar</span>

                    </div>
                    <div class="text-sm font-semibold cursor-pointer text-text2 tracking-wider hover:text-[#e9b02f]">Curso
                    </div>
                </div>

            </div> --}}

        </div>
        <form action="{{ route('page.preinscripcion.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')


            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="cedula" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Número
                        de Cédula o DNI
                    </label>
                    <input type="number" id="cedula" name="cedula"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="29000000" required />
                </div>

                <div>
                    <label for="nombre_completo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nombre
                        completo
                    </label>
                    <input type="text" id="nombre_completo" name="nombre"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="John" required />
                </div>

                <div>
                    <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Número
                        de telefonos
                    </label>
                    <input type="tel" id="telefono" name="telefono"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required />
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo
                        Electronico</label>
                    <input type="email" id="email" name="correo"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Academia@gamil.com" required />
                </div>


                <div>
                    <label for="nacimiento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha de
                        nacimiento</label>
                    <input type="date" id="nacimiento" name="nacimiento"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="nacimiento" required />
                </div>

                <div>
                    <label for="edad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Edad</label>
                    <input type="number" id="edad" name="edad"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="edad" required />
                </div>
                <div>
                    <label for="direccion"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
                    <input type="text" id="direccion" name="direccion"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="ingrese dirección de domicilio" required />
                </div>
                <div>
                    <label for="ocupacion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ocupación o
                        oficio</label>
                    <input type="text" id="ocupacion" name="ocupacion"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="ingrese dirección de domicilio" required />
                </div>
                <div>
                    <label for="grado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Grado de
                        instrucción</label>
                    <input type="text" id="grado" name="grado"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="ingrese grado de instrucción (basica, secundadria, universisdad o N/A)" required />
                </div>
                <div>
                    <!-------subir file--------->
                    <label
                        class="flex  w-[240px] mx-auto cursor-pointer appearance-none justify-center rounded-md border border-dashed border-gray-300 bg-white px-3 py-6 text-sm transition hover:border-gray-400 focus:border-solid focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600 disabled:cursor-not-allowed disabled:bg-gray-200 disabled:opacity-75"
                        tabindex="0">
                        <span for="photo-dropbox" class="flex items-center space-x-2">
                            <svg class="h-6 w-6 stroke-gray-400" viewBox="0 0 256 256">
                                <path d="M96,208H72A56,56,0,0,1,72,96a57.5,57.5,0,0,1,13.9,1.7" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></path>
                                <path d="M80,128a80,80,0,1,1,144,48" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="24"></path>
                                <polyline points="118.1 161.9 152 128 185.9 161.9" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="24"></polyline>
                                <line x1="152" y1="208" x2="152" y2="128" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="24"></line>
                            </svg>
                            <span class="text-xs font-medium text-gray-600">
                                subir una foto del estudiante en formato: png, jpg, jpje
                                <span class="text-blue-600 underline">Cargar foto</span>
                            </span>
                        </span>
                        <input id="photo-dropbox" type="file" name="foto" class="sr-only" />
                    </label>
                </div>
            </div>


            <div class="mb-6">
                <label for="countries"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white ">Cursos</label>
                <select id="countries"
                    class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
                    <option selected disabled>Seleccione el curso</option>
                    @foreach ($niveles as $nivel)
                    <option value="{{$nivel->codigo}}">{{$nivel->nombre}} - Inversión: {{$nivel->precio}}$</option>
                    @endforeach

                </select>
            </div>
            <div class="mb-6">
                <label for="countries"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white ">Plan de pago</label>
                <select id="countries"
                    class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required>
                    <option selected disabled>Seleccione el plan de pago</option>
                    @foreach ($planes as $plan)
                    <option value="{{$plan->codigo}}">{{$plan->nombre}} - Cantidad de cuotas: {{$plan->cantidad_cuotas}} - Plazo: {{$plan->plazo}} Días</option>
                    @endforeach

                </select>
            </div>


            <!-- <h3 class="mb-2  text-gray-900 dark:text-white font-light">Metodos de pago</h3> -->
            <div class=" mb-4">
                <ul
                    class="items-center   w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center ps-3">
                            <input id="horizontal-list-radio-license" type="radio" value="pago_en_plataforma" name="list-radio"
                                class="checkbox_pago w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="horizontal-list-radio-license"
                                class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Hacer
                                el pago
                            </label>
                        </div>
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center ps-3">
                            <input id="horizontal-list-radio-id" type="radio" value="pago_en_academia" name="list-radio"
                                class="checkbox_pago w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="horizontal-list-radio-id"
                                class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Pago
                                en la Académia
                            </label>
                        </div>
                    </li>

                </ul>
            </div>

            {{-- Información de pago --}}
            <div class="mb-6" id="informacion_pago">
             


            </div>

            {{-- Terminos y condiciones el checkbox --}}
            <div class="flex items-start mb-6">
                <div class="flex items-center h-5">
                    <input id="remember" type="checkbox" value=""
                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                        required />
                </div>
                <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Apceotos los
                    <a href="#descargarPdf" class="text-blue-600 hover:underline dark:text-blue-500">
                        Terminos y
                        condiciones</a>.
                </label>
            </div>

            {{-- Boton de enviar --}}
            <div class="flex justify-center">
                <button type="submit"
                    class=" text-whitebg bg-[#BC1E2B] text-white hover:bg-[#d44f5a] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Enviar
                </button>
            </div>
        </form>
    </div>


    <script src="{{ asset('assets/js/master.js') }}" defer></script>
    <script src="{{ asset('assets/js/preinscripciones/index.js') }}" defer></script>
@endsection
