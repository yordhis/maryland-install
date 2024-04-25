    let selectBuscarGrupo = document.getElementById("codigo_grupo"),
    cardDataGrupo = document.getElementById('grupoData');

  
    const hanledBuscarGrupo = (e) =>{
        e.preventDefault();
        cardDataGrupo.innerHTML = preload;
        getGrupo(e.target.value)
        .then(res => {
            log(res)
            if(res.estatus == HTTP_OK){
                localStorage.setItem( 'grupo', JSON.stringify(res.data) );
                cardDataGrupo.innerHTML = TarjetaGrupo(res.data);
            }else{
                $.alert({
                    title:"¡Alerta!",
                    content: res.mensaje,
                    type: "orange"
                });
           
            }
        })
        .catch(err =>{
            $.alert({
                title:"Error interno",
                content: "Error al cargar los datos del grupo, si el error persiste por favor llamar a soporte"
                + " error: " + err,
                type: "red"
            });
        })
    }
    
    /** Crear el evento */
    selectBuscarGrupo.addEventListener("change", hanledBuscarGrupo);    
