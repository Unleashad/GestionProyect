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
            $table->string('numeracion');
            $table->date('fecha');
            $table->time('hora_ini');
            $table->time('hora_fin')->nullable();
            $table->string('desplazamiento')->nullable();
            $table->string('m3')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('nombreFirmante')->nullable();
            $table->string('dni')->nullable();
            $table->binary('firmaCliente', 50000)->nullable();
            $table->boolean('estado')->default(true);
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
