<?php

namespace App\Models;

use App\Models\{
    Cuota,
    Dificultade,
    Estudiante,
    Grupo,
    GrupoEstudiante,
    User,
    RolPermiso,
    Permiso,
    Role,
    Inscripcione,
    Representante,
    RepresentanteEstudiante
};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Helpers extends Model
{
    use HasFactory;

    public static $estudiantes;
    public static $fechaCuota;

    public static function destroyData($cedulaEstudiante, $codigoGrupo, $autorizado)
    {
        // Si el codigo grupo es null se elimina todo ya que se esta eliminando el estudiante por completo
        if ($codigoGrupo == null) {
            // Eliminamos Las cuotas relacionads al estudiante en ese grupo
            if ($autorizado['cuotas']) {
                Cuota::where([
                    "cedula_estudiante" => $cedulaEstudiante
                ])->delete();
            }

            // Eliminamos los pagos relacionads al estudiante en ese grupo e inscripcion
            if ($autorizado['pagos']) {
                Pago::where([
                    "cedula_estudiante" => $cedulaEstudiante
                ])->delete();
            }
            // Eliminamos al estudiante del grupo
            if ($autorizado['grupoEstudiante']) {
                GrupoEstudiante::where([
                    "cedula_estudiante" => $cedulaEstudiante
                ])->delete();
            }
            // Eliminamos la inscripcion del estudiante
            if ($autorizado['inscripcione']) {
                Inscripcione::where([
                    "cedula_estudiante" => $cedulaEstudiante
                ])->delete();
            }
            // Eliminamos la Representantes del estudiante
            if ($autorizado['representanteEstudiante']) {
                RepresentanteEstudiante::where([
                    "cedula_estudiante" => $cedulaEstudiante
                ])->delete();
            }
            // Eliminamos la Representantes del estudiante
            if ($autorizado['dificultadEstudiante']) {
                DificultadEstudiante::where([
                    "cedula_estudiante" => $cedulaEstudiante
                ])->delete();
            }
        }else{
            // Eliminamos Las cuotas relacionads al estudiante en ese grupo
            if ($autorizado['cuotas']) {
                Cuota::where([
                    "cedula_estudiante" => $cedulaEstudiante,
                    "codigo_grupo" => $codigoGrupo,
                ])->delete();
            }
    
            // Eliminamos los pagos relacionads al estudiante en ese grupo e inscripcion
            if ($autorizado['pagos']) {
                Pago::where([
                    "cedula_estudiante" => $cedulaEstudiante,
                    "codigo_grupo" => $codigoGrupo,
                ])->delete();
            }
            // Eliminamos al estudiante del grupo
            if ($autorizado['grupoEstudiante']) {
                GrupoEstudiante::where([
                    "cedula_estudiante" => $cedulaEstudiante,
                    "codigo_grupo" => $codigoGrupo,
                ])->delete();
            }
            // Eliminamos la inscripcion del estudiante
            if ($autorizado['inscripcione']) {
                Inscripcione::where([
                    "cedula_estudiante" => $cedulaEstudiante,
                    "codigo_grupo" => $codigoGrupo,
                ])->delete();
            }
        }
    }

    public static function getRepresentante($cedula)
    {
        return Representante::where(['cedula' => $cedula])->get();
    }

    public static function setFechasHorasNormalizadas($datos)
    {
        $fechaInscripcion = Carbon::parse($datos->fecha);
        $dtInit = Carbon::parse($datos->grupo['fecha_inicio']);
        $dtEnd = Carbon::parse($datos->grupo['fecha_fin']);
        $htInit = Carbon::parse($datos->grupo['hora_inicio']);
        $htEnd = Carbon::parse($datos->grupo['hora_fin']);

        // Normalizando fechas y horas
        $datos->fecha_init = $dtInit->format('d-m-Y');
        $datos->fecha_end = $dtEnd->format('d-m-Y');
        $datos->hora_init = $htInit->format('h:ia');
        $datos->hora_end = $htEnd->format('h:ia');
        $datos->fecha = $fechaInscripcion->format('d-m-Y');

        return $datos;
    }

    public static function updateCedula($cedulaActual, $cedulaNueva)
    {

        try {
            // Pagos
            Pago::where('cedula_estudiante', $cedulaActual)->update([
                "cedula_estudiante" => $cedulaNueva
            ]);
            // Inscripciones
            Inscripcione::where('cedula_estudiante', $cedulaActual)->update([
                "cedula_estudiante" => $cedulaNueva
            ]);

            // Grupos
            GrupoEstudiante::where('cedula_estudiante', $cedulaActual)->update([
                "cedula_estudiante" => $cedulaNueva
            ]);

            // Dificultades 
            DificultadEstudiante::where('cedula_estudiante', $cedulaActual)->update([
                "cedula_estudiante" => $cedulaNueva
            ]);

            // Representantes 
            RepresentanteEstudiante::where('cedula_estudiante', $cedulaActual)->update([
                "cedula_estudiante" => $cedulaNueva
            ]);


            return true;
        } catch (\Throwable $th) {
            $errorInfo = Helpers::getMensajeError($th, "Error al Actualizar La Cédula del estudiante en todas sus relaciones en el objeto helper método updateCedula,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    public static function setDificultades($listDificultades, $cedulaEstudiante)
    {
        foreach ($listDificultades as $insertDificultad) {
            $d = DificultadEstudiante::updateOrCreate(
                [
                    // Para comparar
                    "cedula_estudiante" => $cedulaEstudiante,
                    "dificultad" => $insertDificultad->nombre
                ],
                [
                    // Para las nueva inserción
                    "dificultad" => $insertDificultad->nombre,
                    "estatus" => $insertDificultad->estatus
                ]
            );
        }
    }

    public static function asignarRepresentante($cedulaEstudiante, $cedulaRepresentante)
    {
        if (isset($cedulaEstudiante) && isset($cedulaRepresentante)) {
            return RepresentanteEstudiante::create([
                "cedula_estudiante" => $cedulaEstudiante,
                "cedula_representante" => $cedulaRepresentante
            ]);
        } else {
            return false;
        }
    }

    public static function setRepresentantes($request)
    {
        try {
            /** Se registra el representante */
            Representante::updateOrCreate([
                // Comparamos
                "cedula" => $request->rep_cedula,
            ], [
                // Se actualiza o Crea el representante 
                "nombre" => $request->rep_nombre ?? '',
                "edad" => $request->rep_edad ?? '',
                "ocupacion" => $request->rep_ocupacion ?? '',
                "telefono" => $request->rep_telefono ?? '',
                "direccion" => $request->rep_direccion ?? '',
                "correo" => $request->rep_correo ?? '',
            ]);

            /** Relacionamos los estudiante con el representante */
            RepresentanteEstudiante::updateOrCreate([
                "cedula_estudiante" => $request->cedula,
            ], [
                "cedula_representante" => $request->rep_cedula
            ]);
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            $errorInfo = Helpers::getMensajeError($th, "Error al Registrar el representante en el objeto helper,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }
    }

    public static function getUsuarios()
    {
        $usuarios = User::all();
        foreach ($usuarios as $key => $usuario) {
            $usuarios[$key] = self::getUsuario($usuario->id);
        }
        return $usuarios;
    }

    public static function getUsuario($id)
    {
        $usuario = User::where("id", $id)->get()[0];
        if ($usuario) {
            $usuario->permisos = self::getPermisosUsuario(RolPermiso::where("id_rol", $usuario->rol)->get());
            $usuario->rol = Role::where("id", $usuario->rol)->get()[0];
        }
        return $usuario;
    }

    public static function getPermisosUsuario($permisos)
    {
        $permisosObject = [];
        foreach ($permisos as $permiso) {
            $permisosObject[$permiso->id_permiso] = Permiso::where('id', $permiso->id_permiso)->get()[0];
        }
        return $permisosObject;
    }


    /** Esta funcion retorna el siguiente codigo de la tabla solicitada */
    public static function getCodigo($table)
    {
        $ultimoCodigo = DB::table($table)->max('codigo');
        $code = Carbon::now();
        $code->year($ultimoCodigo);
        $code->setYear($code->year + 1);
        $codigo = explode("-", $code->toDateString())[0];
        return $codigo;
    }

    public static function getMensajeError($e, $mensaje)
    {
        $errorInfo = $mensaje . " ("
            . $e->getMessage() . ")."
            . "Código de error: " . $e->getCode()
            . "Linea de error: " . $e->getLine()
            . "El archivo: " . $e->getFile()
            ?? 'No hay mensaje de error';
        return $errorInfo;
    }

    /**
     * Esta funcion recibe la informacion del formulario y detecta cuales son los input que
     * contienen el prefijo @var dif_ y las convierte en un array.
     *
     * @param Request
     */
    public static function getArrayInputs($request, $prefijo = "dif")
    {
        $array = null;
        foreach ($request as $key => $value) {
            $text = substr($key, 0, 3);

            if ($text == $prefijo) : $array[] = $value;
                continue;
            endif;
        }

        return $array;
    }

    /**
     * Esta funcion retorna los checkbox activos de los elementos deseados
     * @param datos array
     * @param inputChecks array
     */

    public static function getCheckboxActivo($datos, $inputChecks)
    {
        foreach ($datos as $key => $dato) {
            $dato->activo = 0;
            foreach ($inputChecks as $check) {
                if ($dato->id == $check) $dato->activo = 1;
            }
        }
        return $datos;
    }
    /**
     * Esta funcion recibe la informacion del formulario y detecta cuales son los input que
     * contienen las dificultades y las convierte en un array y despues solicita las dificultades
     * y las configura cual esta activa o no pra retornar un array con cotas las dificultades
     * activas e inactivas para se almacenadas en el estudiante
     *
     * @param Request
     */
    public static function getDificultades($request)
    {
        $dificultades = null;
        $listDificultades = Dificultade::all();

        foreach ($request as $key => $value) {
            $text = substr($key, 0, 3);
            if ($text == "dif") : $dificultades[] = $value;
                continue;
            endif;
        }

        if ($dificultades) {
            foreach ($listDificultades as $listDificultad) {
                foreach ($dificultades as $nombreDificultad) {
                    if ($nombreDificultad == $listDificultad->nombre) {
                        $listDificultad->estatus = 1;
                        break;
                    } else {
                        $listDificultad->estatus = 0;
                    }
                }
            }
        } else {
            foreach ($listDificultades as $listDificultad) {
                $listDificultad->estatus = 0;
            }
        }

        return $listDificultades;
    }

    /**
     * Esta funcion retorna toda la informacion relacionada con el estudiante como:
     * @var Representantes
     * @var Dificultades
     */
    public static function getEstudiantes()
    {

        $estudiantes = Estudiante::where('estatus', 1)->get();
        foreach ($estudiantes as $key => $estudiante) {
            $estudiantes[$key] = self::getEstudiante($estudiante->cedula);
        }

        return $estudiantes;
    }

    public static function getEstudiante($cedula)
    {
        if (isset($cedula)) {
            $estudiante = Estudiante::where([
                "cedula" => $cedula,
                "estatus" => 1
            ])->get();

            if (isset($estudiante[0])) {
                $estudiante = $estudiante[0];

                // Obrenemos los representantes
                $estudiante['representantes'] = RepresentanteEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();
                if (count($estudiante['representantes'])) {
                    foreach ($estudiante['representantes'] as $key => $repre) {
                        $estudiante['representantes'][$key] = count(Representante::where('cedula', $repre['cedula_representante'])->get()) >= 1
                            ? Representante::where('cedula', $repre['cedula_representante'])->get()[0]
                            : [];
                    }
                }

                // Obtenemos las dificultades de apredizaje del estudiante
                $estudiante['dificultades'] = DificultadEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();

                // obtenemos los grupos donde esta el estudiante
                $grupos = GrupoEstudiante::where('cedula_estudiante', $estudiante->cedula)->get();
                $estudiante['grupos'];

                foreach ($grupos as $key => $grupo) {
                    $grupos[$key] = Grupo::where('codigo', $grupo->codigo_grupo)->get()[0] ?? [];
                }
                $estudiante['grupos'] = $grupos;


                // Obtenemos todos los datos de inscripción del estudiante
                $inscripciones = Inscripcione::where("cedula_estudiante", $estudiante->cedula)->get() ?? [];
                if (count($inscripciones)) {

                    $inscripciones = Helpers::addDatosDeRelacion(
                        $inscripciones,
                        [
                            "grupos" => "codigo_grupo",
                            "planes" => "codigo_plan",
                        ]
                    );
                }
                $estudiante['inscripciones'] = $inscripciones;

                if (isset($estudiante['inscripciones'][0])) {
                    foreach ($estudiante['inscripciones'] as $key => $inscripcion) {
                        $inscripcion['grupo'] = Helpers::addDatosDeRelacion(
                            Helpers::setConvertirObjetoParaArreglo($inscripcion['grupo']),
                            [
                                "niveles" => "codigo_nivel",
                                "profesores" => "cedula_profesor",
                            ]
                        );
                        $inscripcion['grupo'] = $inscripcion['grupo'][0];
                    }

                    // Obtenemos toda las cuotas
                    foreach ($estudiante['inscripciones'] as $inscripcion) {
                        $inscripcion['cuotas'] = Cuota::where(
                            [
                                'cedula_estudiante' => $inscripcion['cedula_estudiante'],
                                'codigo_grupo' => $inscripcion['codigo_grupo'],
                            ]
                        )->get();
                        // Calculamos el total abonado a esa inscripcion
                        $totalAbonado = 0;
                        foreach ($inscripcion['cuotas'] as $cuota) {
                            if ($cuota->estatus == 1) {
                                $totalAbonado += $cuota->cuota;
                            }
                        }
                        $inscripcion['totalAbonado'] = $totalAbonado;
                    }

                    // formateamos la cedula
                    $estudiante->cedulaFormateada = number_format($estudiante->cedula, 0, ',', '.');
                }
            }
        } else {
            $estudiante = [];
        }
        return $estudiante;
    }

    /**
     * Esta funcion se encarga de guardar la imagen en el store en la direccion public/fotos
     * recibe los siguientes parametros
     * @param request  Estes es el elemento global de las peticiones y se accede a su metodo file y atributo file
     * @return url Retorna la direccion donde se almaceno la imagen
     */
    public static function setFile($request)
    {
        // Movemos la imagen a storage/app/public/fotos
        $imagen = $request->file('file')->store('public/fotos');

        // configuramos la url de /public a /storage
        $url = Storage::url($imagen);

        // Retorna la URL de la imagen
        return $url;
    }

    /**
     * Eliminamos la imagen o archivo anterior
     * @param url se solicita la url del archivo para removerlo de su ubicacion
     */
    public static function removeFile($url)
    {
        $paths = str_replace('storage', 'public', $url);
        if (Storage::delete($paths)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Seteamos la data relacional a los grupos y retornamos los datos
     *
     * @param array
     * Este recibe el arreglo donde se desea añadir la informacion de las relaciones.
     *
     * @param arrayKey
     * Este parametro recibe un array asociativo que el key hace referencia a la tabla de la base de datos
     * y el valor al key de relacion a la otra tabla de la DB.
     *
     * ejemplo: ["profesores" => "cedula_profesor"]
     * Aqui buscamos los datos de la tabla grupos
     * desde el cedula_profesor
     *
     */

    public static function addDatosDeRelacion($array, $arrayKey, $sqlExtra = "")
    {
        if (count($array)) {
            foreach ($array as $key => $value) {
                foreach ($arrayKey as $keyTable => $valueKey) {
                    $llave = explode("_", $valueKey);
                    // return DB::select("select * from {$keyTable} where {$llave[0]} = :{$valueKey} {$sqlExtra}", [$value[$valueKey]]);
                    $array[$key][$llave[1]] = count(DB::select("select * from {$keyTable} where {$llave[0]} = :{$valueKey} {$sqlExtra}", [$value[$valueKey]])) > 1
                        ? DB::select("select * from {$keyTable} where {$llave[0]} = :{$valueKey} {$sqlExtra}", [$value[$valueKey]])
                        : DB::select("select * from {$keyTable} where {$llave[0]} = :{$valueKey} {$sqlExtra}", [$value[$valueKey]])[0] ?? [];
                }
            }
        }

        return $array;
    }

    /**
     * @param Object ### Recibe un objeto ###
     *  Esta funcion se encarga de convertir un objecto en una Arreglo Asociativo y asigna
     *  una llave o posicion [0]->data
     *
     */
    public static function setConvertirObjetoParaArreglo($object)
    {
        return [get_object_vars($object)];
    }
    //
    /**
     * Añadiendo la matricula de cada grupo
     *
     */
    public static function setMatricula($grupos)
    {
        foreach ($grupos as $key => $value) {
            $grupos[$key]['matricula'] = GrupoEstudiante::where([
                "estatus" => 1,
                "codigo_grupo" => $value->codigo,
            ])->count();
        }
        return $grupos;
    }

    /**
     * Validar si el dato existe
     */

    public static function datoExiste($data, $array = ["tabla" => ["campo", "sqlExtra", "key"]])
    {
        foreach ($array as $key => $value) {
            return $result = count(DB::select("select * from {$key} where {$value[0]} = :codigo {$value[1]}", [$data[$value[2]]]))
                ? DB::select("select * from {$key} where {$value[0]} = :codigo {$value[1]}", [$data[$value[2]]])[0]
                : false;
        }
    }

    /**
     * Esta funcion configura las cuotas del estudiante
     * y retorna un array
     */

    public static function getCuotas($data)
    {
        $arrayCuotas = [];
        $dataExtra = static::addDatosDeRelacion(
            [["codigo_grupo" => $data->codigo_grupo, "codigo_plan" => $data->codigo_plan]],
            [
                "grupos" => "codigo_grupo",
                "planes" => "codigo_plan",
            ]
        )[0];

        $dataExtra["grupo"] = static::addDatosDeRelacion(
            Helpers::setConvertirObjetoParaArreglo($dataExtra["grupo"]),
            [
                "niveles" => "codigo_nivel",
            ]
        )[0];

        $nivel = $dataExtra["grupo"]["nivel"];
        $plan = $dataExtra["plan"];
        static::setFechaCuota($data["fecha"]);

        $monto = static::getMontoCuota($plan, $nivel);

        for ($i = 0; $i < $plan->cantidad_cuotas; $i++) {
            array_push($arrayCuotas, [
                "cedula_estudiante" => $data["cedula_estudiante"],
                "codigo_grupo" => $data["codigo_grupo"],
                "fecha" => $i == 0 ? $data["fecha"] : static::getFechaCuota($plan),
                "cuota" => $monto,
                "estatus" => 0,

            ]);
        }

        return $arrayCuotas;
    }

    /**
     * Esta funcion calcula el rango de las fecha y retorna la siguiente fecha
     * de la cuota a cobrar
     *
     */
    public static function getFechaCuota($plan)
    {
        $dt = Carbon::create(self::getFechaCuotaActual());
        $date = explode(" ", $dt->addDays($plan->plazo))[0];
        static::setFechaCuota($date);
        return $date;
    }

    public static function setFechaCuota($fecha)
    {
        static::$fechaCuota = $fecha;
    }

    public static function getFechaCuotaActual()
    {
        return self::$fechaCuota;
    }

    public static function getMontoCuota($plan, $nivel)
    {
        $monto = ($nivel->precio / $plan->cantidad_cuotas);
        return self::auto_decimal_format($monto);
    }

    public static function registrarCuotas($cuotas)
    {
        try {
            foreach ($cuotas as $cuota) {
                Cuota::create([
                    "cedula_estudiante" => $cuota["cedula_estudiante"],
                    "codigo_grupo" => $cuota["codigo_grupo"],
                    "fecha" => $cuota["fecha"],
                    "cuota" => $cuota["cuota"],
                    "estatus" => $cuota["estatus"],
                ]);
            }
        } catch (\Throwable $th) {
            $errorInfo = static::getMensajeError($th, "Error al Registrar las cuotas del estudiante en el método store,");
            return response()->view('errors.404', compact("errorInfo"), 404);
        }

        return true;
    }

    public static function auto_decimal_format($n, $def = 2)
    {
        $a = explode(".", $n);
        if (count($a) > 1) {
            $b = str_split($a[1]);
            $pos = 1;
            foreach ($b as $value) {
                if ($value != 0 && $pos >= $def) {
                    $c = number_format($n, $pos);
                    $c_len = strlen(substr(strrchr($c, "."), 1));
                    if ($c_len > $def) {
                        return rtrim($c, 0);
                    }
                    return $c; // or break
                }
                $pos++;
            }
        }
        return number_format($n, $def);
    }
} // end
