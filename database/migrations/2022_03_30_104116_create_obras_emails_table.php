<?php

use App\Models\Email;
use App\Models\Obra;
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
    // public function up()
    // {
    //     Schema::create('obras_emails', function (Blueprint $table) {
    //         $table->foreignIdFor(Obra::class)->references('id')->on('obras')->cascadeOnDelete();
    //         $table->foreignIdFor(Email::class)->references('id')->on('emails')->cascadeOnDelete();
    //         $table->primary(['obra_id', 'email_id']);
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obras_emails');
    }
};
