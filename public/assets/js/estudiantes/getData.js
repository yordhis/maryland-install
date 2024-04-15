if (document.getElementById("buscarEstudiante")) {
    let inputCedula = document.getElementById("cedula"),
        cardDataEstudiante = document.getElementById("dataEstudiante"),
        elementoPreload = document.getElementById("preload_inscriciones"),
        inputMontoBs = document.getElementById("monto_bs"),
        inputMontoUsd = document.getElementById("monto_usd"),
        // cardCuotaEstudiante = document.getElementById("cuotasEstudiante"),
        divMetodos = document.getElementById("divMetodos"),
        metodos = document.querySelectorAll(".metodo"),
        btnBuscarEstudiante = document.getElementById("buscarEstudiante"),
        botonSubmit = document.querySelector(".boton") ?? "",
        inputReferencia = document.getElementById("referencia"),
        URLpatname = window.location.pathname,
        URLhref = window.location.href,
        estudiantes = [];

    const log = console.log,
        URL_BASE_API = URLhref.split(URLpatname)[0] + "/api",
        URL_BASE_HOST = URLhref.split(URLpatname)[0],
        HTTP_OK = 200,
        HTTP_NOT_FOUND = 404,
        preload = `
            <!-- Growing Color spinnersr -->
            <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-secondary" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
            <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>
        `;

    /** Cargar tarjetas añadidas de estudiantes */
    const hanledLoad = async () => {
        if (localStorage.getItem('estudiantes')) {
            estudiantes = JSON.parse(localStorage.getItem('estudiantes'));

            await estudiantes.forEach(estudiante => {
                cardDataEstudiante.innerHTML += getCardData(estudiante);
            });
            await cargerEventosDeBotonEliminar();

            elementoPreload.innerHTML = "";
        }
    };

    addEventListener('load', hanledLoad);


    function getCardData(data) {
        log(data)

            return `
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="row g-0">

                        <div class="col-xs-12 col-md-3">
                            <img src="${data.foto}" class="img-fluid rounded-start" alt="...">
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="card-body">
                                <h5 class="card-title">Datos personales</h5>
                                        <p class="card-text" style="font-size: 12px;"> 
                                            <b>Nombre y apellido:</b> ${data.foto}  <br>
                                            <b>Nombre y apellido:</b> ${data.nombre.toUpperCase()}  <br>
                                            <b>Cédula o RIF:</b> ${data.nacionalidad}-${data.cedula} <br>
                                            <b>Teléfono movil:</b> ${data.telefono} <br>
                                            <b>Correo:</b> ${data.correo} <br>
                                            <b>Fecha de nacimiento:</b> ${new Date(data.nacimiento).toLocaleDateString('en-US')} <br>
                                            <b>Edad:</b> ${data.edad} años <br>
                                            <b>Grado de instrucción:</b> ${data.grado} <br>
                                            <b>Ocupación:</b> ${data.ocupacion} 
                                        </p>
                                
                                        
                                        
                                        <!-- <p class="card-text"><small class="text-muted">Última actualización hace 3 minutos</small></p> -->
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <ul class="list-group list-group-flush my-2">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Inscriciones realizadas:</b>
                                    <span class="badge text-bg-primary rounded-pill">${data.inscripciones.length}</span>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-danger btn-eliminar" id="${data.cedula}">
                                Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            `;
        
    }

    function getDataEstudiante(cedula) {
        if (cedula.value.length > 6) {
            elementoPreload.innerHTML = preload;
            // cardCuotaEstudiante.innerHTML = preload;

            setTimeout(() => {
                fetch(URL_BASE_API + "/getEstudiante/" + cedula.value)
                    .then((response) => response.json())
                    .then((data) => {
                        log(data);
                        if (data.estatus == HTTP_OK) {
                            estudiantes.forEach(estudiante =>{
                                log(data.data.cedula)
                                if(estudiante.cedula == data.data.cedula){
                                    return alert(' El estudiante ya está agregado a la planilla de inscripción.')
                                }
                            });
                            estudiantes.push(data.data);
                            localStorage.setItem('estudiantes', JSON.stringify(estudiantes));
                            estudiantes = JSON.parse(localStorage.getItem('estudiantes'));
                            hanledLoad();
                        } else {
                           alert(data.mensaje);
                        }
                        setTimeout(() => {
                            cargerEventosDeBotonEliminar();
                        }, 1000)

                    })
                    .catch((err) => {
                        log(err);
                        cardDataEstudiante.innerHTML = err;

                    });
            }, 1500);
        }
    }

    btnBuscarEstudiante.addEventListener("click", (e) => {
        e.preventDefault();
        getDataEstudiante(inputCedula);
    });

    inputCedula.addEventListener("submit", (e) => {
        e.preventDefault();
        getDataEstudiante(e.target);
    });




    // log(metodos);
    if (divMetodos) {
        divMetodos.addEventListener("click", (e) => {
            // log(e.target);

            if (e.target.localName == "input" && e.target.checked === true) {
                // let text = e.target.nextElementSibling.innerText;
                metodos.forEach((metodo) =>
                    metodo.value != e.target.value
                        ? (metodo.required = false)
                        : (metodo.required = true)
                );

                if (e.target.value == "PAGO MOVIL") {
                    inputReferencia.required = true;
                    inputMontoBs.required = true;
                    inputMontoUsd.value = 0;
                }

                if (e.target.value == "EFECTIVO") {
                    inputMontoBs.required = true;
                    inputMontoUsd.value = 0;
                }

                if (e.target.value == "TD") {
                    inputMontoBs.required = true;
                    inputMontoUsd.value = 0;
                }

                if (e.target.value == "DIVISAS") {
                    inputMontoUsd.required = true;
                    inputMontoBs.value = 0;
                }
            }

            if (e.target.localName == "input" && e.target.checked === false) {
                // let text = e.target.nextElementSibling.innerText;
                if (e.target.value == "PAGO MOVIL") {
                    inputReferencia.required = false;
                }
            }
        });
    }


    /** cargar eventos de boton eliminar */
    async function cargerEventosDeBotonEliminar() {
        let botones = document.querySelectorAll('.btn-eliminar'),
            nuevaListaDeEstudiantes = [];
        console.log(botones);


        botones.forEach(boton => {
            boton.addEventListener('click', (e) => {
                console.log(e.target);
                console.log(e.target.id);
                elementoPreload.innerHTML = preload;
                cardDataEstudiante.innerHTML = "";
                nuevaListaDeEstudiantes = estudiantes.filter(estudiante => estudiante.cedula != e.target.id);
                setTimeout(() => {
                    console.log("--------- NUEVA LISTA  -------- ");
                    console.log(nuevaListaDeEstudiantes);
                    localStorage.setItem('estudiantes', JSON.stringify(nuevaListaDeEstudiantes));
                    estudiantes = nuevaListaDeEstudiantes;

                    estudiantes.forEach(estudiante => {
                        cardDataEstudiante.innerHTML += getCardData(estudiante);
                    });
                    elementoPreload.innerHTML = "";
                }, 1500);
            });
        });


    }

}

