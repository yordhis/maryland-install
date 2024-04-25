<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UsuarioController,
    ApiController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::match(['get', 'post', 'put', 'delete'], '/{model}/{action?}/{id?}', function ($model=null, $action=null, $id=null) {
    //
    // return $request;
    // return $response;
    // return isset($id) ? $id : "hola";
    // return $_SERVER['METHOD_REQUEST'];
    // $httpRequest =  $_SERVER['REQUEST_METHOD'];
    // Route::get('/users/{user}', [UserController::class, 'show']);
//     Route::$httpRequest( "/{$model}/{$action}", [UsuarioController::class, 'index'] );
// });

Route::get('/getCodigoInscripcion/{incrementar}', [ApiController::class, 'getCodigoInscripcion'])->name('api.getCodigoInscripcion');
Route::get('/getEstudiante/{cedula}', [ApiController::class, 'getEstudiante'])->name('api.getEstudiante');
Route::get('/getRepresentante/{cedula}', [ApiController::class, 'getRepresentante'])->name('api.getRepresentante');
Route::get('/grupo/{codigo}', [ApiController::class, 'getGrupo'])->name('api.getGrupo');
Route::get('/plan/{codigo}', [ApiController::class, 'getPlan'])->name('api.getPlan');
Route::post('/createCuotas', [ApiController::class, 'createCuotas'])->name('api.createCuotas');
