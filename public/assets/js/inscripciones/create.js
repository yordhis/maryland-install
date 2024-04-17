let cardDataEstudiante = document.getElementById("dataEstudiante"),
    elementoPreload = document.getElementById("preload_inscriciones"),
    elementoFormasDePagos = document.getElementById("formasDePagos"),
    estudiantes = [],
    abonos = {
        metodo: "",
        monto:"",
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

    if (localStorage.getItem('estudiantes')) {
        cardDataEstudiante.innerHTML = "";

        estudiantes = JSON.parse(localStorage.getItem('estudiantes'));

        await estudiantes.forEach(estudiante => {
            cardDataEstudiante.innerHTML += AccordionComponente(estudiante);
        });
        await cargerEventosDeBotonEliminar();

        elementoPreload.innerHTML = "";
    }
};

addEventListener('load', hanledLoad);

/** cargar eventos de boton eliminar */
async function cargerEventosDeBotonEliminar() {
    let botones = document.querySelectorAll('.btn-eliminar'),
        nuevaListaDeEstudiantes = [];

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