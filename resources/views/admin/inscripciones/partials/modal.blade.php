
        
<!-- Vertically centered Modal -->
<a type="button" class="text-success" data-bs-toggle="modal" data-bs-target="#verticalycentered{{$inscripcione->id}}">
    <i class="bi bi-journal-plus fs-3"></i>
</a>
    


<div class="modal fade" id="verticalycentered{{$inscripcione->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Asignar nota</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action=" {{ route( 'admin.notas.update', $inscripcione->id ) }}" method="post" >
            @csrf
            @method('put')
            <div class="modal-body">
                <div class="col-12">
                <p>
                    Esta nota será asignada a la inscripción del Nivel <b>{{$inscripcione->grupo['nivel']->nombre}}</b> <br>
                    del estudiante <b> {{ $inscripcione->estudiante->nombre ?? ''}}</b>.
                </p>
                    
                    <label for="yourPassword" class="form-label">Ingrese nota</label>
                    <input type="text" name="nota" class="form-control" id="yourUsername" 
                    placeholder="Ingrese nota del estudiante"
                    value="{{ explode("/", $inscripcione->nota)[0] ?? "" }}"
                    required>
                    <div class="invalid-feedback">Por favor, Ingrese nota!</div>
                </div>
                <div class="col-12">
                    <label for="yourPassword" class="form-label">Ingrese Sobre cuanto se evaluó</label>
                    <input type="text" name="notaMaxima" class="form-control" id="yourUsername" 
                    placeholder="Ingrese sobre cuanto se evaluó."
                    value="{{ explode("/", $inscripcione->nota)[1] ?? "" }}"
                    required>
                    <div class="invalid-feedback">Por favor, Ingrese sobre cuanto se evaluó!</div>
                </div>
            </div>
            <div class="modal-footer">
                <small class="text-danger"></small>
              
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Asignar nota</button>
            </div>
        </form>
    </div>
    </div>
</div><!-- End Vertically centered Modal-->


