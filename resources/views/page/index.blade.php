@extends('layouts.page')


@section('content')
    <!-----------container banner slider-->
    <div id="default-carousel" class="relative w-full " data-carousel="slide">
        <!-- Carousel wrapper -->
        <div
            class="-z-10  relative h-[130px] phone_1:h-[340px] phone_2:h-[390px] phone_3:h-[420px] tablet:h-[500px] md:h-[630px] lg:h-[720px] xl:h-[800px] 2xl:h-[880px] overflow-hidden rounded-lg ">
            <!-- Item 1 -->
            <div class="hidden duration-[2000ms]  ease-in-out" data-carousel-item>
            
                <img src="{{ asset('/src/images/banner_1.jpg')}}"
                    class="absolute  w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2  block
                    "
                    alt="banner_1">

            </div>

            <!-- Item 2 -->
            <div class="hidden duration-[2000ms] ease-in-out" data-carousel-item>
                <img src="{{ asset('/src/images/ing.jpg') }}"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="banner_2">
            </div>

            <!-- Item 3 -->
            <div class="hidden duration-[1000ms]  ease-in-out" data-carousel-item>
                <img src="{{ asset('/src/images/high 1.jpg') }}"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 " alt="banner_3">
            </div>
        </div>


        <!-- Slider controls -->
        <button type="button"
            class=" absolute top-0 start-0 z-40 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-100/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>

        <button type="button"
            class="absolute top-0 end-0 z-40 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-100/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>


    <!--------PLANES--------->
    <section
        class="z-30 bg-center  phone_1:-mt-[100px] phone_2:-mt-[80px]  xl:-mt-[90px] 2xl:-mt-9  bg-no-repeat  bg-white bg-blend-multiply">
        <div class="">

            <section class="relative block px-6 py-2 md:py-8 md:px-10  ">

                <div class="relative mx-auto max-w-5xl text-center">

                    <h2
                        class="block w-full bg-gradient-to-b from-white bg-clip-text font-bold text-[#BC1E2B] text-3xl sm:text-4xl">
                        Planes de Inscripción por Nivel (Trimestral)
                    </h2>

                    <p
                        class="mx-auto my-0 w-full max-w-xl bg-transparent mt-1 text-center font-medium leading-snug tracking-wide text-black">
                        "En Nuestra <b>Academia Maryland</b> aprenderás a hablar inglés en corto tiempo para que tengas
                        una mayor proyección y estatus en el colegio, Universidad, en tu puesto de trabajo o en tu
                        propio negocios"
                    </p>
                </div>


                <div
                    class="relative mx-auto w-[100%] phone_3:w-[75%] sm:w-[95%] md:w-[90%] xl:w-[65%] 2xl:w-[60%] z-10 grid grid-cols-1 gap-10 pt-14 sm:grid-cols-2 ">



                    @foreach ($planes as $plan)
                        
                    @endforeach

                    <div class="rounded-md border border-[#BC1E2B]  p-8 text-center shadow-md">
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
                        <h3 class="mt-2 text-black font-bold">Plan Individual:<span class="text-[#BC1E2B]"> 180$ De
                                contado</span></h3>
                        <p class="my-1 mb-0  leading-relaxed tracking-wide font-semibold text-black">Crédito
                            faccionado: 200$<br>Cuota 1: 100$ (INICIAL)<br> Cuota 2: 100$ A los 30 Dias
                        </p>

                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white rounded-lg hover:bg-[#bc1e2bea]  ">
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


                    <div class="rounded-md border border-[#BC1E2B]  p-8 text-center shadow-md">
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
                        <h3 class="mt-2 text-black font-bold">Plan Duo:<span class="text-[#BC1E2B]"> 240$ De
                                contado</span></h3>
                        <p class="my-1 mb-0  leading-relaxed tracking-wide font-semibold text-black">Crédito
                            faccionado: 260$<br> Cuota 1: 130$ (INICIAL)<br> Cuota 2: 130$ A los 30 Dias
                        </p>

                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white rounded-lg hover:bg-[#bc1e2bea]  ">
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

                </div>
            </section>
        </div>


    </section>


    <!------section_de curso de niño------->

    <section id="nino" class=" z-10 mt-8 pl-[10px] pr-[10px] border-[#bc1e2b73] border-t-4 ">

        <div class="relative mx-auto max-w-5xl mt-4 text-center">

            <h1
                class="block w-full bg-gradient-to-b from-white bg-clip-text font-bold text-[#BC1E2B] text-3xl sm:text-4xl">
                ¡Curso para todas las Edades!
            </h1>
            <p
                class="mx-auto my-0 w-full max-w-xl bg-transparent mt-1 text-center font-medium leading-snug tracking-wide text-black">
                "Aprende de la manera divertida a través de juegos, canciones, actividades y conversaciones."
            </p>
        </div>

        <h2 class="py-2 font-semibold text-[#BC1E2B] text-[160%]">Curso para Niños</h2>

        {{-- cursos para niños --}}
        <div
            class="grid align-middle mb-5 phone_1:grid-cols-1  phone_3:grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">

            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/high-1.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 1</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400">¡Inscríbelo en un viaje
                            educativo que los hará sonreír mientra aprende!.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>
            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/high-2.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 2</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400">¡Inscríbelo en un viaje
                            educativo que los hará sonreír mientra aprende!.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>
            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/high-3.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 3</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400">¡Inscríbelo en un viaje
                            educativo que los hará sonreír mientra aprende!.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>
            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/high-4.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 4</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400">¡Inscríbelo en un viaje
                            educativo que los hará sonreír mientra aprende!.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>
            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/high-5.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 5</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400">¡Inscríbelo en un viaje
                            educativo que los hará sonreír mientra aprende!.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>

        </div>


        <h1 class=" py-4 font-semibold text-[#BC1E2B] text-[160%] ">Curso para Adolescentes y Adultos</h1>
        
        <!--------- curso de jovenesy adultos----------->
        <div
            class="grid align-middle phone_1:grid-cols-1  phone_3:grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-3">

            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/initial.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 1</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400 text-center"><b>¿Quieres
                                perfeccionar tu inglés?</b><br>
                            Únete a nuestro curso avanzado y conquista la fluidez y <span
                                class="text-[#e9b02f] font-semibold">práctica constante</span>.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>
            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/basic.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 2</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400 text-center"><b>¿Quieres
                                perfeccionar tu inglés?</b><br>
                            Únete a nuestro curso avanzado y conquista la fluidez y <span
                                class="text-[#e9b02f] font-semibold">práctica constante</span>.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>
            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/intermediate1.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 3</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400 text-center"><b>¿Quieres
                                perfeccionar tu inglés?</b><br>
                            Únete a nuestro curso avanzado y conquista la fluidez y <span
                                class="text-[#e9b02f] font-semibold">práctica constante</span>.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>
            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/intermediate2.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 4</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400 text-center"><b>¿Quieres
                                perfeccionar tu inglés?</b><br>
                            Únete a nuestro curso avanzado y conquista la fluidez y <span
                                class="text-[#e9b02f] font-semibold">práctica constante</span>.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>

            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/advanced.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 5</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400 text-center"><b>¿Quieres
                                perfeccionar tu inglés?</b><br>
                            Únete a nuestro curso avanzado y conquista la fluidez y <span
                                class="text-[#e9b02f] font-semibold">práctica constante</span>.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>

            <div class=" mx-auto">


                <div
                    class="max-w-sm   bg-white border border-[#bc1e2b44] rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('page.preinscripcion.index') }}">
                        <img class="rounded-t-lg  w-full" src="../src/images/conversational.jpg" alt="" />
                    </a>
                    <div class="p-3">
                        <a href="{{ route('page.preinscripcion.index') }}">
                            <h5
                                class="mb-2  text-center text-[100%] phone_1:text-[125%] md:text-[130%] font-bold tracking-tight text-gray-900 dark:text-white">
                                Nivel 6</h5>
                        </a>
                        <p class="mb-3 font-normal text-[95%] text-gray-700 dark:text-gray-400 text-center"><b>¿Quieres
                                perfeccionar tu inglés?</b><br>
                            Únete a nuestro curso avanzado y conquista la fluidez y <span
                                class="text-[#e9b02f] font-semibold">práctica constante</span>.</p>
                        <a href="{{ route('page.preinscripcion.index') }}"
                            class="inline-flex items-center bg-[#BC1E2B] mx-auto w-full px-2 py-2  font-medium  text-white  rounded-lg hover:bg-[#bc1e2bea]  ">
                            <span class="mx-auto text-[90%] flex ">
                                Inscripciones Abiertas
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2 my-auto" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </span>
                        </a>

                    </div>
                </div>

            </div>

        </div>

    </section>
@endsection






