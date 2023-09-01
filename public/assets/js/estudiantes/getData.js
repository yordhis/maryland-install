
let inputCedula = document.getElementById("cedula"),
    cardDataEstudiante = document.getElementById("dataEstudiante"),
    inputMontoBs = document.getElementById("monto_bs"),
    inputMontoUsd = document.getElementById("monto_usd"),
    cardCuotaEstudiante = document.getElementById("cuotasEstudiante"),
    divMetodos = document.getElementById("divMetodos"),
    metodos = document.querySelectorAll(".metodo"),
    btnBuscarEstudiante = document.getElementById("buscarEstudiante"),
    botonSubmit = document.querySelector(".boton") ?? "",
    inputReferencia = document.getElementById("referencia"),
    URLpatname = window.location.pathname,
    URLhref = window.location.href;

const log = console.log,
    URL_BASE_API = URLhref.split(URLpatname)[0] + "/api",
    URL_BASE_HOST = URLhref.split(URLpatname)[0],
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
    `,
    cardRegistrarEstudiante = `
    <div class="card mb-3 rounded-5 shadow" >
        <div class="row g-0">

           

            <div class="col-md-12">
                <div class="card-body">
                    <p class="card-text">
                        <h5 class="card-text text-dark">El Estudiante no esta registrado</h5>
                        <p class="card-text text-dark">
                            Ingrese otra cédula o proceda a registrar al estudiante,
                            haga click en el boton para ir a la sección de registro.
                        </p>
                        <div class="d-grid gap-2 mt-3">
                            <a href="/estudiantes/create" target="_self" class="btn btn-primary" >Ir a Registro de estudiante</a>
                        </div>
                    </p>
                </div>
            </div>

        </div>
    </div>
    `;

function getEsAprobado(nota) {
    if (nota) {
        nota = nota.split("/");

        notaMinima = parseInt(nota[1]) / 2;
        if (parseInt(nota[0]) >= notaMinima) {
            return {
                estatus: "Aprobado",
                class: "bi bi-journal-check text-success",
                fondo: "",
            };
        } else {
            return {
                estatus: "Reprobado",
                class: "bi bi-journal-x text-danger",
                fondo: "bg-danger text-white",
            };
        }
    }
    return {
        estatus: "No posee nota",
        class: "bi bi-journal-x text-danger",
        fondo: "bg-warning text-danger text-lg",
    };
}

function getCardData(data) {
    if (data.id === undefined) {
        return cardRegistrarEstudiante;
    } else {
        return `
            <div class="card mb-3 rounded-5 shadow" >
                <div class="row g-0">

                    <div class="col-md-2">
                        <img src="${data["foto"]}" class="img-fluid rounded-start" alt="foto">
                    </div>

                    <div class="col-md-5">
                        <div class="card-body">
                            <p class="card-text">
                                <h5 class="card-text text-dark">Estudiante</h5>
                                <b class="fs-5 text-primary"> ${data["nombre"]} </b> <br>
                                <small class="text-muted fs-6">${data["cedula"]}</small> <br>
                                <small class="text-muted fs-6">${data["edad"]} años</small> 
                            </p>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card-body">
                            <p class="card-text">
                                <h5 class="card-text text-dark">Contacto</h5>
                                <b class="fs-5 text-primary"> ${data["telefono"]} </b> <br>
                                <small class="text-muted fs-6">${data["correo"]}</small> <br>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        `;
    }
}

function getCardCuotas(inscripcion) {
    let cuotas = inscripcion.cuotas,
        esAprobado;

    if (!cuotas.length) {
        return (cardCuotaEstudiante.innerHTML = "");
    }

    let totalAbonado = 0,
        cuotasPendientes,
        cuotasPendientesHtml,
        abono = cuotas.map((cuota) =>
            cuota.estatus == 1 ? parseFloat(cuota.cuota) : 0
        );

    totalAbonado = abono.reduce((a, b) => a + b);

    // capturar cuotas pendientes
    if (URLpatname == "/inscripciones/create") {
    
        cuotasPendientes = cuotas.map((cuota, key) =>
            cuota.estatus == 0
                ? `
                ${key == 0 ? '<ul class="nav flex-column">' : ''}
                <li class="nav-item cuotas">
                    <a type="button" class="nav-link text-danger"
                        target="_self" 
                        href="${URL_BASE_HOST}/pagos/${cuota.cedula_estudiante}/estudiante">
                        ${cuota.fecha} | ${cuota.cuota} $
                    </a>
                </li>
                ${key == cuotas.length - 1 ? `
                    </ul>
                    <p class="text-muted fs-6 w-50">
                        Selecciones una cuota y sera redireccionado al módulo de pago.
                    </p>
                
                ` : ''}
            `
                : ''
        );

    } else {

        cuotasPendientes = cuotas.map((cuota) =>
            cuota.estatus == 0
                ? `
                <div class="form-check form-check-inline cuotas">
                    <input class="form-check-input" type="checkbox" id="${cuota.id}" name="cuo_${cuota.id}" value="${cuota.id}">
                    <label class="form-check-label text-danger" for="${cuota.cedula_estudiante}">
                        ${cuota.fecha} | ${cuota.cuota} $
                    </label>
                </div>
            `
                : ''
        );
    }

    // Verificamos si hay cuotas pendentes para activar la alerta y desactivar
    // El boton de procesar inscripción
    let pendientes = cuotas.map((value) => value.estatus == 0 ? value : 0),
    activarAlert = pendientes.filter(pendiente => pendiente != 0);
    if(activarAlert.length && URLpatname.split('/')[1] != 'pagos'){
        alert(`El estudiante ${inscripcion.nombre} tiene cuotas pendientes; Por lo tanto no se puede procesar su inscripción.`);
        botonSubmit.disabled = true;
    }
   
    // Concatenamos todas las cuotas pendientes
    cuotasPendientesHtml = cuotasPendientes.reduce((a, b) => a + b, "");
    // log(cuotasPendientesHtml);

    // Comprobamos si el estudiante paso
    esAprobado = getEsAprobado(inscripcion.nota);

    // Mostrar la tarjeta de las cuotas y datos de inscripcion
    return `
        <div class="card mb-3 p-2 rounded-3 shadow" >
        
            <div class="card card-header">
                <h5 class="text-primary">Datos de inscripción</h5>
            </div>
            <div class="d-flex flex-row bd-highlight mb-3">
                <div class="align-self-start text-center p-1">
                    <h5>Total abonado</h5>
                    <h1>${totalAbonado}</h1>
                </div>

                <div class="align-self-start p-1">
                    <h5>Cuotas Pendientes</h5>
                    ${cuotasPendientesHtml}
                </div>
               
                <div class="align-self-start p-1">
                    <!-- List group With Icons -->
                    <ul class="list-group">
                    <li class="list-group-item"><i class="bi bi-star me-1 text-success"></i> 
                    Código Del Grupo Estudio: ${inscripcion.grupo.codigo} </li>
                    <li class="list-group-item"><i class="bi bi-star me-1 text-success"></i> 
                    Nombre del nivel: ${inscripcion.grupo.nivel.nombre} </li>
                    <li class="list-group-item"><i class="bi bi-paypal me-1 text-primary"></i> Precio: ${inscripcion.grupo.nivel.precio}$</li>
                    <li class="list-group-item"><i class="bi bi-award me-1 "></i> Nota: ${inscripcion.nota ?? "No posee nota"}</li>
                    <li class="list-group-item ${esAprobado.fondo}"><i class=" ${esAprobado.class} me-1 "></i> Estatus: ${esAprobado.estatus}</li>
                    
                    </ul><!-- End List group With Icons -->
                </div>
                
            </div>
        
       
        </div>
    `;
}

function getDataEstudiante(cedula) {
    if (cedula.value.length > 6) {
        cardDataEstudiante.innerHTML = preload;
        cardCuotaEstudiante.innerHTML = preload;

        setTimeout(() => {
            fetch(URL_BASE_API + "/getEstudiante/" + cedula.value)
                .then((response) => response.json())
                .then((data) => {
                    // log(data);

                    cardDataEstudiante.innerHTML = getCardData(data);
                    cardCuotaEstudiante.innerHTML = null;
                    data.inscripciones.forEach((inscripcion) => {
                        inscripcion.nombre = data.nombre;
                        // log(inscripcion)
                        cardCuotaEstudiante.innerHTML +=
                            getCardCuotas(inscripcion);
                    });
                })
                .catch((err) => {
                    log(err);
                    cardDataEstudiante.innerHTML = cardRegistrarEstudiante;
                    cardCuotaEstudiante.innerHTML = null;
                });
        }, 3000);
    }
}

btnBuscarEstudiante.addEventListener("click", (e) => {
    e.preventDefault();
    getDataEstudiante(inputCedula);
});

inputCedula.addEventListener("keydown", (e) => {
    getDataEstudiante(e.target);
});

/**
 * Este evento se encarga de detectar las cuotas seleccionadas y sumar las para
 * mostrar un total en el monto de divisas
 */
let montoTotal = 0;
cardCuotaEstudiante.addEventListener("click", (e) => {
    // log(e.target)
    // log(e.target.value)
    // log(e.target.nextElementSibling.innerText)
    if (e.target.localName == "input" && e.target.checked === true) {
        let text = e.target.nextElementSibling.innerText;
        cuotaSelect = text.split("|");
        montoTotal =
            montoTotal + parseFloat(cuotaSelect[cuotaSelect.length - 1]);
        inputMontoUsd.value = montoTotal;
    }

    if (e.target.localName == "input" && e.target.checked === false) {
        let text = e.target.nextElementSibling.innerText;
        cuotaSelect = text.split("|");
        montoTotal =
            montoTotal - parseFloat(cuotaSelect[cuotaSelect.length - 1]);
        inputMontoUsd.value = montoTotal;
    }
});

// log(metodos);
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
