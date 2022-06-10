<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReporteRobos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('reporte_robos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_reporte');
            $table->date('fecha_robo');
            $table->time('hora_robo');
            $table->integer('vehiculo_id')->unsigned();
            $table->text('detalles');
            $table->softDeletes($column = 'deleted_at', $presicion = 0);
            $table->timestamps();
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
