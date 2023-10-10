
if (document.getElementById("codigo_grupo")) {
    let selectBuscarGrupo = document.getElementById("codigo_grupo"),
    cardDataGrupo = document.getElementById('grupoData'),
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
        `;
    
    function getCardGrupo(data){
        return `
                <div class="card-header rounded-5 shadow bg-primary">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">                       
                            <h2 class="text-white">Grupo ${data.nombre}</h2>
                            <p class="text-white">
                                <b class="text-warning">Nivel:</b> ${data.nivel.nombre} <br>
                                <b class="text-warning">Libro:</b> ${data.nivel.libro} <br>
                                <b class="text-warning">Inversión:</b> ${data.nivel.precio} $ <br>
                                <b class="text-warning">Matricula:</b> ${data.matricula} estudiantes 
                            </p>
                        
                        </div>
    
                        <div class="col-sm-6 text-end">                       
                            <h2 class="text-white">Código: <b class="text-warning">${data.codigo}</b></h2>
                            <p class="text-white">
                                <b class="text-warning">Profesor:</b> ${data.profesor.nombre} <br>
                                <b class="text-warning">Fecha de Inicio del curso:</b> ${data.fecha_inicio} <br>
                                <b class="text-warning">Fecha de Finalización del curso:</b> ${data.fecha_fin} <br>
                                <b class="text-warning">Horario:</b> De: ${data.hora_inicio} hasta ${data.hora_fin} <br>
                                <b class="text-warning">Días:</b> ${data.dias} 
    
                            </p>
                        </div>
    
                    </div>
                </div>
            </div>
        `;
    }
    
    function  getDataGrupo(codigo){
        cardDataGrupo.innerHTML = preload;
        setTimeout(() => {
            fetch(URL_BASE_API + "/grupo/" + codigo)
                .then((response) => response.json())
                .then((data) => {
                    log(data)
                    cardDataGrupo.innerHTML = getCardGrupo(data);
                })
                .catch((err) => {
                    // log(err)
                    cardDataGrupo.innerHTML = "Error al cargar los datos del grupo, si el error persiste por vafor llamar a soporte"
                    + " error: " + err;
                    
                });
        }, 3000);
    }
    
    selectBuscarGrupo.addEventListener("change", (e)=>{
        e.preventDefault();
        getDataGrupo(e.target.value);
    });       
}
