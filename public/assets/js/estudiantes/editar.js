
if (document.getElementById("addRepresentante") && document.getElementById("btnAddRepresentante")) {

    console.log("esta vacio o es null");
    let addRepresentante = document.getElementById("addRepresentante"),
    btnAddRepresentante = document.getElementById("btnAddRepresentante");
    
    const insputsRepresentante = `
    <!-- INICIO DE DATOS DEL REPRESENTANTE -->
    <div id="agregar-representante" class="row">
        <div class="col-11">
            <h5 class="mt-3">Representante</h5>
            <hr>
        </div>
        <div class="col-1">
            <span class="text-danger fs-3" id="closeRepre">X</span>
        </div>
        <div class="col-12">
            <label for="yourName" class="form-label">Nombre del representante</label>
            <input type="text" name="rep_nombre" class="form-control" id="yourName"
                placeholder="Ingrese Nombre del representante." >
            <div class="invalid-feedback">Por favor, Nombre del representante!</div>
        </div>
        <div class="col-6">
            <label for="yourUsername" class="form-label">Cédula</label>
            <input type="text" name="rep_cedula" class="form-control"
                id="yourUsername" placeholder="Ingrese la cédula del representante."
                >
            <div class="invalid-feedback">Por favor, Ingrese la cédula del representante!
            </div>
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
    </div> <!-- FIN DE DATOS DEL REPRESENTANTE -->
    `;
    
    btnAddRepresentante.addEventListener('click', (e)=>{
        e.preventDefault();
        addRepresentante.innerHTML = insputsRepresentante;
    
    })
}