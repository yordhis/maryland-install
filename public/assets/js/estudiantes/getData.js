if (document.getElementById("buscarEstudiante")) {
    let inputCedula = document.getElementById("cedula"),
        cardDataEstudiante = document.getElementById("dataEstudiante"),
        elementoPreload = document.getElementById("preload"),
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
        HTTP_NOT_FOUND = 200,
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
                   
                    </div>
                </div>
    
            </div>
        </div>
        `;

    addEventListener('load', ()=>{
  
        if(localStorage.getItem('estudiantes')){
            estudiantes = JSON.parse( localStorage.getItem('estudiantes') );
            estudiantes.forEach(estudiante =>{
                cardDataEstudiante.innerHTML += getCardData(estudiante);
            });
            cargerEventosDeBotonEliminar();
        }

    });
    
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
                <div class="card mb-3" style="max-width: 100%;">
                    <div class="row g-0">

                        <div class="col-xs-12 col-md-3">
                            <img src="${data.foto}" class="img-fluid rounded-start" alt="...">
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="card-body">
                                <h5 class="card-title">Datos personales</h5>
                                        <p class="card-text" style="font-size: 12px;"> 
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
            elementoPreload.innerHTML = preload;
            // cardCuotaEstudiante.innerHTML = preload;
    
            setTimeout(() => {
                fetch(URL_BASE_API + "/getEstudiante/" + cedula.value)
                    .then((response) => response.json())
                    .then((data) => {
                        log(data);
                        if (data.estatus == HTTP_OK) {
                            estudiantes.push(data.data);
                            localStorage.setItem('estudiantes', JSON.stringify(estudiantes));
                            estudiantes = JSON.parse( localStorage.getItem('estudiantes') );
                            estudiantes.forEach(estudiante =>{
                                cardDataEstudiante.innerHTML += getCardData(estudiante);
                            });
                            elementoPreload.innerHTML = "";
                        } else {
                            cardDataEstudiante.innerHTML += cardRegistrarEstudiante;
                            elementoPreload.innerHTML = "";
                        }
                        setTimeout(()=>{
                            cargerEventosDeBotonEliminar();
                        },1000)
                       
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
    
    inputCedula.addEventListener("keydown", (e) => {
        getDataEstudiante(e.target);
    });
    
    /**
     * Este evento se encarga de detectar las cuotas seleccionadas y sumar las para
     * mostrar un total en el monto de divisas
     */
    let montoTotal = 0;
    // cardCuotaEstudiante.addEventListener("click", (e) => {
 
    //     if (e.target.localName == "input" && e.target.checked === true) {
    //         let text = e.target.nextElementSibling.innerText;
    //         cuotaSelect = text.split("|");
    //         montoTotal =
    //             montoTotal + parseFloat(cuotaSelect[cuotaSelect.length - 1]);
    //         inputMontoUsd.value = montoTotal;
    //     }
    
    //     if (e.target.localName == "input" && e.target.checked === false) {
    //         let text = e.target.nextElementSibling.innerText;
    //         cuotaSelect = text.split("|");
    //         montoTotal =
    //             montoTotal - parseFloat(cuotaSelect[cuotaSelect.length - 1]);
    //         inputMontoUsd.value = montoTotal;
    //     }
    // });
    
    // log(metodos);
    if(divMetodos){
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
    function cargerEventosDeBotonEliminar() {
        let botones = document.querySelectorAll('.btn-eliminar'),
        nuevaListaDeEstudiantes = [];
        console.log(botones);

       
        botones.forEach(boton => {
            boton.addEventListener('click', (e)=>{
                console.log(e.target);
                console.log(e.target.id);
                elementoPreload.innerHTML = preload;
                cardDataEstudiante.innerHTML = "";
                nuevaListaDeEstudiantes = estudiantes.filter(estudiante => estudiante.cedula != e.target.id);
                setTimeout(()=>{
                    console.log("--------- NUEVA LISTA  -------- ");
                    console.log(nuevaListaDeEstudiantes);
                    localStorage.setItem('estudiantes', JSON.stringify(nuevaListaDeEstudiantes));
                    estudiantes = nuevaListaDeEstudiantes;
                   
                        estudiantes.forEach(estudiante =>{
                            cardDataEstudiante.innerHTML += getCardData(estudiante);
                        });
                        elementoPreload.innerHTML = "";
                }, 1500);
            });
        });


    }

}

