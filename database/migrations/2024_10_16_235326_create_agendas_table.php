<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id(); // Llave primaria
            $table->string('nombres');
            $table->string('correo');
            $table->string('telefono');
            $table->string('tiposervicio');
            $table->date('fecha');
            
            // Relación con el modelo Empleado
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendas');
    }
}
