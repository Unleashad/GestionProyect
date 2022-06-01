<?php

use App\Models\Servicio;
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
        Schema::create('albarans', function (Blueprint $table) {
            $table->id();
            $table->string('numeracion')->unique();
            $table->timestamps();
            $table->foreignIdFor(Servicio::class)->references('id')->on('servicios')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albarans');
    }
};
