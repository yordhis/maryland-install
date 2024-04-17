let btnAddRepre = document.getElementById('addRepre'),
btnAddDifi = document.getElementById('addDifi');
closeRepre = document.getElementById('closeRepre'),
closeDifi = document.getElementById('closeDifi'),
formCreate = document.forms[1];

if(document.getElementById('agregar-representante')){
    representanteElemento = document.getElementById('agregar-representante');
    representanteElemento.hidden = true;
}
if(document.getElementById('agregar-dificultad')){
    dificultadElemento = document.getElementById('agregar-dificultad');
    dificultadElemento.hidden = true;
}

btnAddRepre.addEventListener('click', (e) => {
    e.preventDefault; 
    for (const input of formCreate) {
        if (input.name.includes('rep_')) {
            input.required=true
            console.log(input.name);
        }
    }

    btnAddRepre.classList.add('text-warning');
    displayElemento(representanteElemento, false);
});

btnAddDifi.addEventListener('click', (e) => {
    e.preventDefault; 
    btnAddDifi.classList.add('text-warning');
    displayElemento(dificultadElemento, false);
});

closeRepre.addEventListener('click', (e)=>{
    for (const input of formCreate) {
        if (input.name.includes('rep_')) {
            input.required=false
        }
    }
    displayElemento(representanteElemento, true);
    btnAddRepre.classList.replace('text-warning', 'text-primary');
});

closeDifi.addEventListener('click', (e)=>{
    displayElemento(dificultadElemento, true)
    btnAddDifi.classList.replace('text-warning', 'text-primary');
});

const displayElemento = (elemento, accion) => elemento.hidden=accion;
