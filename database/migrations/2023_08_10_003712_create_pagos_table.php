<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 55)->nullable();
            $table->string('cedula_estudiante', 55)->nullable();
            $table->string('codigo_grupo', 55)->nullable();
            $table->string('concepto', 55)->nullable();
            $table->string('id_cuota', 55)->nullable();
            $table->string('fecha', 55)->nullable();
            $table->string('metodo', 55)->nullable(); // se guardan separados por comas (,)
            $table->string('monto', 55)->nullable(); // abono
            $table->string('referencia', 55)->nullable();
            $table->string('estatus', 55)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
