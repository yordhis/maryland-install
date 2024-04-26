<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ConceptoController,
    CuotaController,
    UserController,
    DashboardController,
    ProfesoreController,
    EstudianteController,
    NiveleController,
    PlaneController,
    GrupoController,
    GrupoEstudianteController,
    PagoController,
    InscripcioneController,
    LoginController,
    NotaController
};


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
})->middleware('guest');

/**
 * Rutas de Profesor
 */
Route::get('/login', [LoginController::class, 'index'])->name('login.index')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::resource('/login', LoginController::class)->names('login')->middleware('guest');



Route::middleware('auth')->group(function () {
    Route::get('/panel', [DashboardController::class, 'index'])->name('admin.panel.index');
    // muestra todas las cuotas atrazadas
    Route::get('/cuotas', [CuotaController::class, 'index'])->name('admin.coutas.index');
    
    /**
     * Rutas de controlador usuarios
     */
    /** Vistas */
    Route::resource('/usuarios', UserController::class)->names('admin.usuarios');
    
    /**
     * Rutas de Profesor
     */
    Route::resource('/profesores', ProfesoreController::class)->names('admin.profesores');
    
    /**
     * Rutas de Estudiante
     */
    
    Route::resource('/estudiantes', EstudianteController::class)->names('admin.estudiantes');
    
    /**
     * Rutas de Niveles de estudio
     */
    Route::resource('/niveles', NiveleController::class)->names('admin.niveles');
    
    /**
     * Rutas de Planes de pago
     */
    Route::resource('/planes', PlaneController::class)->names('admin.planes');
    
    /**
     * Rutas de Grupos de estudio
     */
    Route::get('/imprimirMatriculaDelGrupo/{codigoGrupo}', [GrupoController::class, 'imprimirMatriculaDelGrupo'])->name('admin.grupos.imprimir');
    Route::resource('/grupos', GrupoController::class)->names('admin.grupos');
    Route::resource('/grupoEstudiantes', GrupoEstudianteController::class)->names('admin.grupoEstudiantes');
    
    
    /**
     * Rutas de Planes de pago
     */
    Route::get('/pagos/{cedula}/{codigo_inscripcion}', [PagoController::class, 'getPagoEstudiante'])->name('admin.pagos.process');
    Route::get('/generarReciboDePago/{cedula_estudiante}/{codigo_inscripcion}/', [PagoController::class, 'recibopdf'])->name('admin.pagos.recibopdf');
    Route::resource('/pagos', PagoController::class)->names('admin.pagos');
    
    /**
     * Rutas de Inscripciones de estudiantes
     */
    
    Route::get('/inscripciones/estudiante',[InscripcioneController::class, 'createEstudiante'])->name('admin.inscripciones.createEstudiante');

    
    /**  */
    Route::get('/inscripciones/{cedula}/{codigo}', [InscripcioneController::class, 'planillapdf'])->name('admin.inscripciones.pdf');
    Route::resource('/inscripciones', InscripcioneController::class)->names('admin.inscripciones');
    Route::resource('/notas', NotaController::class)->names('admin.notas');
    
    /**
     * Rutas de Concepto de estudiantes
     */
    
    Route::resource('/conceptos', ConceptoController::class)->names('admin.conceptos');
    
});