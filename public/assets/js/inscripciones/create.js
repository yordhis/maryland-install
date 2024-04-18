let cardDataEstudiante = document.getElementById("dataEstudiante"),
    elementoPreload = document.getElementById("preload_inscriciones"),
    elementoFormasDePagos = document.getElementById("formasDePagos"),
    inputCodigo = document.getElementById("codigo"),
    inputEstudiantes = document.getElementById("estudiantes"),
    estudiantes = [],
    abonos = {
        metodo: "",
        monto: "",
    };
// inputMontoBs = document.getElementById("monto_bs"),
// inputMontoUsd = document.getElementById("monto_usd"),
// cardCuotaEstudiante = document.getElementById("cuotasEstudiante"),
// divMetodos = document.getElementById("divMetodos"),
// metodos = document.querySelectorAll(".metodo"),
// btnBuscarEstudiante = document.getElementById("buscarEstudiante"),
// botonSubmit = document.querySelector(".boton"),
// inputReferencia = document.getElementById("referencia"),


/** Cargar tarjetas añadidas de estudiantes */
const hanledLoad = async () => {

    elementoPreload.innerHTML = preload;
   
    estudiantes = JSON.parse(localStorage.getItem('estudiantes'));
    if (estudiantes.length) {
        cardDataEstudiante.innerHTML = "";
        inputCodigo.value = ""
        inputEstudiantes.value = ""

       await listarEstudiantes(getCodigoInscripcion, estudiantes)
        .then(async res =>{
           
            if(res.estatus){
                /** Guardamos en memoria y localStorage */
                estudiantes = res.data;
                localStorage.setItem('estudiantes', JSON.stringify(estudiantes))

                /** Agregar los acordiones de los estudiantes */
                estudiantes.forEach(estudiante => {
                    cardDataEstudiante.innerHTML += AccordionComponente(estudiante);
                });

              
                elementoPreload.innerHTML=""
                await cargerEventosDeBotonEliminar();
            }
        });
       
    }else{
        $.confirm({
            title: "¡Alerta!",
            type: 'red',
            content: "No hay estudiantes para procesar una inscripción, le redireccionaremos a la seccion de agregar estudiante",
            buttons:{
                confirm:{
                    text: "Ok",
                    action: function() {
                        elementoPreload.innerHTML = "";
                        window.location.href = URL_BASE_HOST + "/inscripciones/estudiante";
                    }
                }
            }
        })
    }
    
  
};

addEventListener('load', hanledLoad);

/** cargar eventos de boton eliminar */
function cargerEventosDeBotonEliminar() {
    let botones = document.querySelectorAll('.btn-eliminar'),
        nuevaListaDeEstudiantes = [];
    log(botones)
    
    botones.forEach(boton => {
        boton.addEventListener('click', (e) => {
            nuevaListaDeEstudiantes = estudiantes.filter(estudiante => estudiante.cedula != e.target.id);
            setTimeout(() => {
                localStorage.setItem('estudiantes', JSON.stringify(nuevaListaDeEstudiantes));
                hanledLoad();
            }, 1500);
        });
    });
}

const listarEstudiantes = (getCodigo, estudiantes) => {
    return new Promise( (resolve, reject) => {
        setTimeout(() => {
            estudiantes.forEach((estudiante, index) => {
                getCodigo(index)
                .then(res => {
                    if(res.estatus == HTTP_OK) {

                        estudiante.codigoInscripcion = res.data;
                        inputEstudiantes.value += estudiante.cedula + ',';
                        inputCodigo.value += estudiante.codigoInscripcion + ',';
    
                    } else $.alert({
                        title: "¡Alerta!",
                        type: 'red',
                        content: res.mensaje + " (Recomendamos que recargue la página con F5)",
                    })
                });
            });
                 
            resolve({
                data: estudiantes,
                estatus: true
            })
        },1000);
    })
}