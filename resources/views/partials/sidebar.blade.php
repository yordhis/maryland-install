@php
$url = explode('/', $_SERVER['REQUEST_URI']);
$categoria = strtoupper($url[1]);
if (isset($url[2])) {
$subcategoria = strtoupper($url[2]);
} else {
$subcategoria = 'LISTA';
}
@endphp

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @if (Auth::user()->rol == 1 || Auth::user()->rol == 2)
        <!-- Start Components Nav | Panel -->
        <li class="nav-item">
            <a class="nav-link" href="/panel" target="_self">
                <i class="bi bi-grid"></i>
                <span>Panel</span>
            </a>
        </li><!-- End Dashboard Nav | Panel-->

        <!-- Start Components Nav | Profesores -->
        <li class="nav-item">
            <a class="nav-link {{ $categoria == 'PROFESORES' ? 'collapse show' : 'collapsed' }} "
                data-bs-target=" #components-nav-2" data-bs-toggle="collapse" href="#" aria-expanded="true">
                <i class="bi bi-person-vcard"></i><span>Profesores</span><i class="bi bi-chevron-down ms-auto "></i>
            </a>
            <ul id="components-nav-2"
                class="nav-content {{ $categoria == 'PROFESORES' ? 'collapse show' : 'collapse' }} "
                data-bs-parent=" #sidebar-nav">
                <li>
                    <a href="/profesores"
                        class="{{ $categoria == 'PROFESORES' ? ($subcategoria == 'LISTA' ? 'active border rounded' : '') : '' }}"
                        target="_self">
                        <i class="bi bi-circle"></i><span>Lista</span>
                    </a>
                </li>
                <li>
                    <a href="/profesores/create"
                        class="{{ $categoria == 'PROFESORES' ? ($subcategoria == 'CREATE' ? 'active border rounded' : '') : '' }}"
                        target="_self">
                        <i class="bi bi-circle"></i><span>Crear</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav | Profesores -->

        <!-- Start Components Nav | Estudiantes -->
        <li class="nav-item">
            <a class="nav-link {{ $categoria == 'ESTUDIANTES' ? 'collapse show' : 'collapsed' }}"
                data-bs-target="#components-nav-3" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-video3"></i><span>Estudiantes</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-3"
                class="nav-content {{ $categoria == 'ESTUDIANTES' ? 'collapse show' : 'collapse' }} "
                data-bs-parent=" #sidebar-nav">
                <li>
                    <a href="/estudiantes" target="_self"
                        class="{{ $categoria == 'ESTUDIANTES' ? ($subcategoria == 'LISTA' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Lista</span>
                    </a>
                </li>

                <li>
                    <a href="/estudiantes/create" target="_self"
                        class="{{ $categoria == 'ESTUDIANTES' ? ($subcategoria == 'CREATE' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Crear</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav | Estudiantes-->

        <!-- Start Components Nav | Niveles de estudio -->
        <li class="nav-item">
            <a class="nav-link {{ $categoria == 'NIVELES' ? 'collapse show' : 'collapsed' }}"
                data-bs-target="#components-nav-4" data-bs-toggle="collapse" href="#">
                <i class="bi bi-controller"></i><span>Nivel de Estudio</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-4" class="nav-content {{ $categoria == 'NIVELES' ? 'collapse show' : 'collapse' }} "
                data-bs-parent=" #sidebar-nav">
                <li>
                    <a href="/niveles" target="_self"
                        class="{{ $categoria == 'NIVELES' ? ($subcategoria == 'LISTA' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Lista</span>
                    </a>
                </li>
                <li>
                    <a href="/niveles/create" target="_self"
                        class="{{ $categoria == 'NIVELES' ? ($subcategoria == 'CREATE' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Crear</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav | Niveles de estudio -->

        <!-- Start Components Nav | Planes de Pago -->
        <li class="nav-item">
            <a class="nav-link {{ $categoria == 'PLANES' ? 'collapse show' : 'collapsed' }}"
                data-bs-target="#components-nav-5" data-bs-toggle="collapse" href="#">
                <i class="bi bi-signpost-2"></i><span>Planes de Pago</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-5" class="nav-content {{ $categoria == 'PLANES' ? 'collapse show' : 'collapse' }} "
                data-bs-parent=" #sidebar-nav">
                <li>
                    <a href="/planes" target="_self"
                        class="{{ $categoria == 'PLANES' ? ($subcategoria == 'LISTA' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Lista</span>
                    </a>
                </li>
                <li>
                    <a href="/planes/create" target="_self"
                        class="{{ $categoria == 'PLANES' ? ($subcategoria == 'CREATE' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Crear</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav | Planes de Pago -->

        <!-- Start Components Nav | Grupos de Estudios -->
        <li class="nav-item">
            <a class="nav-link {{ $categoria == 'GRUPOS' ? 'collapse show' : 'collapsed' }}"
                data-bs-target="#components-nav-6" data-bs-toggle="collapse" href="#">
                <i class="bi bi-diagram-3"></i><span>Grupos de Estudios</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-6" class="nav-content {{ $categoria == 'GRUPOS' ? 'collapse show' : 'collapse' }} "
                data-bs-parent=" #sidebar-nav">
                <li>
                    <a href="/grupos" target="_self"
                        class="{{ $categoria == 'GRUPOS' ? ($subcategoria == 'LISTA' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Lista</span>
                    </a>
                </li>
                <li>
                    <a href="/grupos/create" target="_self"
                        class="{{ $categoria == 'GRUPOS' ? ($subcategoria == 'CREATE' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Crear</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav | Grupos de Estudios -->

        <!-- Start Components Nav | Pagos -->
        <li class="nav-item">
            <a class="nav-link {{ $categoria == 'PAGOS' ? 'collapse show' : 'collapsed' }}"
                data-bs-target="#components-nav-7" data-bs-toggle="collapse" href="#">
                <i class="bi bi-paypal"></i><span>Pagos</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-7" class="nav-content {{ $categoria == 'PAGOS' ? 'collapse show' : 'collapse' }} "
                data-bs-parent=" #sidebar-nav">
                <li>
                    <a href="/pagos" target="_self"
                        class="{{ $categoria == 'PAGOS' ? ($subcategoria == 'LISTA' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Lista</span>
                    </a>
                </li>
                <li>
                    <a href="/pagos/create" target="_self"
                        class="{{ $categoria == 'PAGOS' ? ($subcategoria == 'CREATE' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Procesar Pago</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav | Pagos -->

        <!-- Start Components Nav | Inscripciones -->
        <li class="nav-item">
            <a class="nav-link {{ $categoria == 'INSCRIPCIONES' ? 'collapse show' : 'collapsed' }}"
                data-bs-target="#components-nav-8" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-plus"></i><span>Inscripciones</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-8"
                class="nav-content {{ $categoria == 'INSCRIPCIONES' ? 'collapse show' : 'collapse' }} "
                data-bs-parent=" #sidebar-nav">
                <li>
                    <a href="/inscripciones" target="_self"
                        class="{{ $categoria == 'INSCRIPCIONES' ? ($subcategoria == 'LISTA' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Lista</span>
                    </a>
                </li>
                <li>
                    <a href="/inscripciones/create" target="_self"
                        class="{{ $categoria == 'INSCRIPCIONES' ? ($subcategoria == 'CREATE' ? 'active border rounded' : '') : '' }}">
                        <i class="bi bi-circle"></i><span>Procesar Inscripción</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav | Incripciones -->
        @endif

        @if (Auth::user()->rol == 1)
        <!-- Start Components Nav | configuraciones -->
        <li class="nav-item">
            <a class="nav-link {{ ($categoria == 'CONCEPTOS' ? 'collapse show' : $categoria == 'USUARIOS') ? 'collapse show' : 'collapsed' }}"
                data-bs-target="#components-nav-10" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i><span>Configuración</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav-10"
                class="nav-content {{ ($categoria == 'CONCEPTOS' ? 'collapse show' : $categoria == 'USUARIOS') ? 'collapse show' : 'collapse' }} "
                data-bs-parent=" #sidebar-nav">

                <!-- Start Components Nav | Conceptos -->
                <li class="nav-item">
                    {{-- conceptos de pago --}}
                    <a class="nav-link {{ $categoria == 'CONCEPTOS' ? 'collapse show' : 'collapsed' }}"
                        data-bs-target="#components-nav-12" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-paypal fs-3"></i><span>Definir conceptos de pago</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav-12"
                        class="nav-content {{ $categoria == 'CONCEPTOS' ? 'collapse show' : 'collapse' }} "
                        data-bs-parent=" #sidebar-nav-1">
                        <li>
                            <a href="conceptos" target="_self"
                                class="{{ $categoria == 'CONCEPTOS' ? ($subcategoria == 'LISTA' ? 'active border rounded' : '') : '' }}">
                                <i class="bi bi-circle"></i><span>Lista</span>
                            </a>
                        </li>
                        <li>
                            <a href="conceptos/create" target="_self"
                                class="{{ $categoria == 'CONCEPTOS' ? ($subcategoria == 'CREATE' ? 'active border rounded' : '') : '' }}">
                                <i class="bi bi-circle"></i><span>Crear</span>
                            </a>
                        </li>

                    </ul>
                </li><!-- End Components Nav | Conceptos -->

                <!-- Start Components Nav | usuarios -->
                <li class="nav-item">
                    <a class="nav-link {{ $categoria == 'USUARIOS' ? 'collapse show' : 'collapsed' }}"
                        data-bs-target="#components-nav-1" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-people fs-3"></i><span>Usuarios</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav-1"
                        class="nav-content {{ $categoria == 'USUARIOS' ? 'collapse show' : 'collapse' }} "
                        data-bs-parent=" #sidebar-nav-1">
                        <li>
                            <a href="usuarios" target="_self"
                                class="{{ $categoria == 'USUARIOS' ? ($subcategoria == 'LISTA' ? 'active border rounded' : '') : '' }}">
                                <i class="bi bi-circle"></i><span>Lista</span>
                            </a>
                        </li>
                        <li>
                            <a href="usuarios/create" target="_self"
                                class="{{ $categoria == 'USUARIOS' ? ($subcategoria == 'CREATE' ? 'active border rounded' : '') : '' }}">
                                <i class="bi bi-circle"></i><span>Crear</span>
                            </a>
                        </li>

                    </ul>
                </li><!-- End Components Nav | usuarios -->

            </ul>
        </li><!-- End Components Nav | configuraciones -->
        @endif

    </ul>


</aside><!-- End Sidebar -->