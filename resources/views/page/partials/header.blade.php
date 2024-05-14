<!--------------navegacion------->
<nav class=" bg-[#FDF9F9] fixed top-0 w-[100%] mx-auto overflow-hidden h-20 flex items-center justify-end md:pr-8  z-50">

    <a href="index.html" class="w-1/2 max-w-[180px] absolute left-[2em]  ">
        <img src="{{ asset('/src/images/logo.png') }}" class="w-[100%]">
    </a>

    <input type="checkbox" id="menu" class="peer hidden">

    <label for="menu"
        class="bg-open-menu w-6 h-5 bg-cover mr-[1em] bg-center cursor-pointer peer-checked:bg-close-menu transition-all z-50 md:hidden"></label>

    <div
        class=" fixed inset-0 bg-gradient-to-b from-white/70 to-black/70 translate-x-full peer-checked:translate-x-0 transition-transform z-40 md:static md:bg-none md:translate-x-0 ">

        <ul
            class="absolute inset-x-0 top-24 p-12 bg-white w-[90%] mx-auto rounded-md h-max text-center grid gap-6 font-bold text-black shadow-2xl md:w-max md:bg-transparent md:p-0 md:grid-flow-col md:static">

            <li>
                <a href="{{ route('page.index') }}">Inicios</a>
            </li>



            <li>
                <a href="{{ route('page.index') }}#nino">Cursos</a>
            </li>

            <li>
                <a href="#contacto">contacto</a>
            </li>
            <li>
                <a href="{{ route('page.preinscripcion.index')}}" class="text-red-900">¡Preinscribir me!</a>
            </li>




        </ul>

    </div>


</nav>
