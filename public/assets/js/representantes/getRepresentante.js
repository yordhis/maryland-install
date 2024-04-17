if (document.getElementById('rep_cedula')) {

    let inputCedulaRepresentante = document.getElementById('rep_cedula'),
        componenteRepresentante = document.getElementById('componenteRepresentante'),
        preloadSpan = document.getElementById('preload'),
        mensajeRepresentante = document.getElementById('mensajeRepresentante'),
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
        inputsRepresentante = `
        <div class="col-12">
            <label for="yourName" class="form-label">Nombre del representante</label>
            <input type="text" name="rep_nombre" class="form-control" id="yourName"
                placeholder="Ingrese Nombre del representante." >
            <div class="invalid-feedback">Por favor, Nombre del representante!</div>
        </div>

        <div class="col-6">
            <label for="yourUsername" class="form-label">Teléfono </label>
            <input type="text" name="rep_telefono" class="form-control"
                id="yourUsername" placeholder="Ingrese teléfono del representante."
                >
            <div class="invalid-feedback">Por favor, Ingrese teléfono del representante!
            </div>
        </div>
        <div class="col-2">
            <label for="yourUsername" class="form-label">Edad</label>
            <input type="number" name="rep_edad" class="form-control" id="yourUsername"
                placeholder="Ingrese edad." >
            <div class="invalid-feedback">Por favor, Ingrese edad!</div>
        </div>
        <div class="col-10">
            <label for="yourUsername" class="form-label">Ocupación</label>
            <input type="text" name="rep_ocupacion" class="form-control"
                id="yourUsername" placeholder="Ingrese ocupación o oficio." >
            <div class="invalid-feedback">Por favor, ocupación o oficio!</div>
        </div>
        <div class="col-12">
            <label for="yourUsername" class="form-label">Dirección del
                representante</label>
            <input type="text" name="rep_direccion" class="form-control"
                id="yourUsername" placeholder="Ingrese dirección del representante."
                >
            <div class="invalid-feedback">Por favor, Ingrese dirección del representante!
            </div>
        </div>
        <div class="col-12">
            <label for="yourUsername" class="form-label">Correo</label>
            <input type="text" name="rep_correo" class="form-control"
                id="yourUsername" placeholder="Ingrese correo." >
            <div class="invalid-feedback">Por favor, Ingrese correo del representante!
            </div>
        </div>
    `;

    const getCardRepresentante = (data) => {
        
        return `
            <div class="accordion accordion-flush " id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed bg-primary text-white p-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <b>Representante: </b> ${data.nombre.toUpperCase()} - C.i: ${data.cedula} | Haga click para ver más datos.
                    </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <h5 class="card-text text-dark">Datos</h5>
                            
                            <small class=" fs-5">
                                <b>Nombre:</b>
                                ${data.nombre.toUpperCase()}
                            </small> <br>
                            <small class=" fs-5">
                                <b>C.I:</b>
                                ${data.cedula}
                            </small> <br>
                            <small class=" fs-5">
                                <b>Correo:</b>
                                ${data.correo}
                            </small> <br>

                            <small class=" fs-5">
                                <b>Dirección:</b> 
                                ${data.direccion}
                            </small> <br>

                            <small class=" fs-5">
                                <b>Telefono:</b> 
                                ${data.telefono}
                            </small> <br>
                           
                            <small class=" fs-5">
                                <b>Edad:</b>
                                ${data.edad} años
                            </small> 
                        </div>
                    </div>
                </div>
            </div>
        `;
    };

    log(componenteRepresentante)

    /** Funcion que Obtiene datos del representante */
    function getRepresentante(cedula) {
        if (cedula.value.length > 6) {
            preloadSpan.innerHTML = preload;
            componenteRepresentante.classList.remove('visible');
            componenteRepresentante.classList.add('invisible');
            setTimeout(() => {

                fetch(URL_BASE_API + "/getRepresentante/" + cedula.value)
                    .then((response) => response.json())
                    .then((result) => {
                        log(result);

                        if (result.estatus == 200) {
                            mensajeRepresentante.textContent = result.mensaje;
                            mensajeRepresentante.classList.remove('bg-danger');
                            mensajeRepresentante.classList.add('bg-success');
                            componenteRepresentante.classList.remove('invisible');
                            componenteRepresentante.classList.add('visible');
                            componenteRepresentante.innerHTML = getCardRepresentante(result.data);
                            preloadSpan.innerHTML = "";
                        } else {
                            mensajeRepresentante.textContent = result.mensaje;
                            mensajeRepresentante.classList.remove('bg-success');
                            mensajeRepresentante.classList.add('bg-danger');
                            preloadSpan.innerHTML = "";
                            componenteRepresentante.classList.remove('invisible');
                            componenteRepresentante.classList.add('visible');
                        }
                    })
                    .catch((err) => {
                        $.alert({
                            title: "Error!",
                            type: "red",
                            content: err.mensaje
                        })
                    });
            }, 3000)

        }
    }

    inputCedulaRepresentante.addEventListener('keyup', (e) => {
        log(e.target.value)
        getRepresentante(e.target)

    })
}