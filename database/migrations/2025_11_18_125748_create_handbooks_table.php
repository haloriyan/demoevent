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
        Schema::create('handbooks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booth_id')->unsigned()->index()->nullable();
            $table->foreign('booth_id')->references('id')->on('booths')->onDelete('set null');
            $table->boolean('kiosk');

            $table->string('title');
            $table->string('filename');
            $table->bigInteger('size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handbooks');
    }
};
