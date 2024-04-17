
    let inputCedula = document.getElementById("cedula"),
        cardDataEstudiante = document.getElementById("dataEstudiante"),
        elementoPreload = document.getElementById("preload_inscriciones"),
        // inputMontoBs = document.getElementById("monto_bs"),
        // inputMontoUsd = document.getElementById("monto_usd"),
        // cardCuotaEstudiante = document.getElementById("cuotasEstudiante"),
        // divMetodos = document.getElementById("divMetodos"),
        // metodos = document.querySelectorAll(".metodo"),
        btnBuscarEstudiante = document.getElementById("buscarEstudiante"),
        botonSubmit = document.querySelector(".boton"),
        // inputReferencia = document.getElementById("referencia"),
        // URLpatname = window.location.pathname,
        // URLhref = window.location.href,
        estudiantes = [];



    /** Cargar tarjetas añadidas de estudiantes */
    const hanledLoad = async () => {
        if (localStorage.getItem('estudiantes')) {
            cardDataEstudiante.innerHTML="";

            estudiantes = JSON.parse(localStorage.getItem('estudiantes'));

            await estudiantes.forEach(estudiante => {
                cardDataEstudiante.innerHTML += AccordionComponente(estudiante);
            });
            
            await cargerEventosDeBotonEliminar();

            elementoPreload.innerHTML = "";
        }
    };

    addEventListener('load', hanledLoad);

    function getDataEstudiante(cedula) {
        if (cedula.value.length > 6) {
            elementoPreload.innerHTML = preload;

            setTimeout(() => {
                fetch(URL_BASE_API + "/getEstudiante/" + cedula.value)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.estatus == HTTP_OK) {
                            let capturado = estudiantes.filter(estudiante => estudiante.cedula == data.data.cedula);
                            
                            if (capturado.length) {
                                return $.alert({
                                    title: "¡Alerta!",
                                    content: "Ya esta agregado",
                                    type:"orange",
                                    action: elementoPreload.innerHTML = ""
                                })
                            } else {
                                return $.alert({
                                    title: "Procesado",
                                    content: "El estudiante se agregó correctamente a la planilla de inscripción.",
                                    type:"green",
                                    action: function(){
                                        estudiantes.push(data.data);
                                        localStorage.setItem('estudiantes', JSON.stringify(estudiantes));
                                        estudiantes = JSON.parse(localStorage.getItem('estudiantes'));
                                        inputCedula.value="";
                                        inputCedula.focus();
                                        hanledLoad();
                                    }()

                                })
                              
                            }
                        } else {

                            return $.alert({
                                title: "¡Alerta!",
                                content: data.mensaje,
                                action: elementoPreload.innerHTML = ""
                            })
                        }


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


    /** cargar eventos de boton eliminar */
    async function cargerEventosDeBotonEliminar() {
        let botones = document.querySelectorAll('.btn-eliminar'),
            nuevaListaDeEstudiantes = [];
            

        botones.forEach(boton => {
            boton.addEventListener('click', (e) => {
                elementoPreload.innerHTML = preload;
                nuevaListaDeEstudiantes = estudiantes.filter(estudiante => estudiante.cedula != e.target.id);
                setTimeout(() => {
                    localStorage.setItem('estudiantes', JSON.stringify(nuevaListaDeEstudiantes));
                    hanledLoad();
                }, 1500);
            });
        });
    }


