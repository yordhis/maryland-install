<?php

namespace App\Exports;

use App\Models\GrupoEstudiante;
use App\Models\Helpers;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportarMatricula implements FromCollection
{
    protected $codigoGrupo;

    function __construct($codigoGrupo)
    {
        $this->codigoGrupo = $codigoGrupo;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $grupo = Helpers::getGrupos($this->codigoGrupo)[0];

        return new Collection([
            ['Grupo:', $grupo->nombre, 'Código:', $grupo->codigo, 'Nivel:', $grupo->nivel_nombre],
            ['Profesor'],
            ['Nombre:', $grupo->profesor_nombre, 'Cédula:', $grupo->profesor_cedula ],
            ['Horario'],
            ['Días:', $grupo->dias, 'Hora:', $grupo->hora_inicio ." hasta ". $grupo->hora_fin, "Fecha de inicio:", $grupo->fecha_inicio, 'Fecha de culminación:', $grupo->fecha_fin],
            ['Estudiantes'],
            ['N°', 'Nombre y apellido', 'Cédula', 'Teléfono', 'Correo', 'edad', 'Cumpleaños', 'Pago Pendiente' ],
        ]);
    }
}
