let representanteElemento = document.getElementById('agregar-representante'),
dificultadElemento = document.getElementById('agregar-dificultad'),
btnAddRepre = document.getElementById('addRepre'),
btnAddDifi = document.getElementById('addDifi');
closeRepre = document.getElementById('closeRepre'),
closeDifi = document.getElementById('closeDifi');

representanteElemento.hidden = true;
dificultadElemento.hidden = true;



btnAddRepre.addEventListener('click', (e) => {
    e.preventDefault; 
    btnAddRepre.classList.add('text-warning');
    displayElemento(representanteElemento, false);
});
btnAddDifi.addEventListener('click', (e) => {
    e.preventDefault; 
    btnAddDifi.classList.add('text-warning');
    displayElemento(dificultadElemento, false);
});

closeRepre.addEventListener('click', (e)=>{
    displayElemento(representanteElemento, true);
    btnAddRepre.classList.replace('text-warning', 'text-primary');
});
closeDifi.addEventListener('click', (e)=>{
    displayElemento(dificultadElemento, true)
    btnAddDifi.classList.replace('text-warning', 'text-primary');
});



const displayElemento = (elemento, accion) => elemento.hidden=accion;
