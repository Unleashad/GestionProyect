<?php

use App\Models\Maquina;
use App\Models\Obra;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora_ini');
            $table->time('hora_fin');
            $table->string('desplazamiento');/*¿?*/
            $table->string('m3');
            $table->text('observaciones');
            $table->timestamps();

            $table->foreignIdFor(User::class)->references('id')->on('users')->cascadeOnDelete();
            $table->foreignIdFor(Maquina::class)->references('id')->on('maquinas')->cascadeOnDelete();
            $table->foreignIdFor(Obra::class)->references('id')->on('obras')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
};