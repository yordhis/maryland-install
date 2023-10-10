if (document.getElementById('rep_cedula')) {
    
    let inputCedulaRepresentante = document.getElementById('rep_cedula'),
    componenteRepresentante = document.getElementById('componenteRepresentante'),
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
    `,
    getCardRepresentante = (data) =>{
        return `
                <div class="card mb-3 rounded-5 shadow" >
                    <div class="row g-0">
    
                        <div class="col-md-6">
                            <div class="card-body">
                                <p class="card-text">
                                    <h5 class="card-text text-dark">Representante</h5>
                                    <b class="fs-5 text-primary"> ${data.nombre} </b> <br>
                                    <small class="text-muted fs-6"><b>C.I:</b>${data.cedula}</small> <br>
                                    <small class="text-muted fs-6"><b>Edad:</b>${data.edad} años</small> 
                                </p>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="card-body">
                                <p class="card-text">
                                    <h5 class="card-text text-dark">Contacto</h5>
                                    <b class="fs-5 text-primary"> ${data.telefono} </b> <br>
                                    <small class="text-muted fs-6">${data.correo}</small> <br>
                                    <small class="text-muted fs-6"><b>Ocupación:</b> ${data.ocupacion}</small> <br>
                                </p>
                            </div>
                        </div>
    
                    </div>
                </div>
            `;
    };
    
    
    /** Funcion que Obtiene datos del representante */
     function getRepresentante(cedula) {
        if (cedula.value.length > 6) {
            componenteRepresentante.innerHTML = preload;
            setTimeout(()=>{

                fetch(URL_BASE_API + "/getRepresentante/" + cedula.value)
                    .then((response) => response.json())
                    .then((result) => {
                        // log(result);
                        
                        if(result.estatus == 200){
                            mensajeRepresentante.textContent = result.mensaje;
                            componenteRepresentante.innerHTML = getCardRepresentante(result.data);
                        }else{
                            mensajeRepresentante.textContent = result.mensaje;
                            componenteRepresentante.innerHTML = inputsRepresentante;
                        }
                    })
                    .catch((err) => {
                        // log(err);
                        // cardDataEstudiante.innerHTML = cardRegistrarEstudiante;
                        // cardCuotaEstudiante.innerHTML = null;
                });
            }, 3000)
         
        }
    }
    
    inputCedulaRepresentante.addEventListener('keyup', (e)=>{
        log(e.target.value)
        getRepresentante(e.target)
        
    })
}