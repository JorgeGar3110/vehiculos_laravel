<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Vehiculos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cat_marca_id')->unsigned();
            $table->integer('modelo');
            $table->string('linea');
            $table->integer('cat_color_id')->unsigned();
            $table->string('vin');
            $table->string('placa');
            $table->softDeletes($column = 'deleted_at', $presicion = 0);
            $table->timestamps();
            $table->foreign('cat_marca_id')->references('id')->on('cat_marcas');
            $table->foreign('cat_color_id')->references('id')->on('cat_colores');
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
