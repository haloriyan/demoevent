<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rundown_speakers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rundown_id')->unsigned()->index();
            $table->foreign('rundown_id')->references('id')->on('rundowns')->onDelete('cascade');
            $table->bigInteger('speaker_id')->unsigned()->index();
            $table->foreign('speaker_id')->references('id')->on('speakers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rundown_speakers');
    }
};
