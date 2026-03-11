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
        Schema::create('ramayanas', function (Blueprint $table) {
            $table->id();
            $table->string('ref');
            $table->string('name');
            $table->string('email');

            $table->bigInteger('price');
            $table->integer('quantity');
            $table->bigInteger('total_pay');

            $table->string('payment_status');
            $table->text('payment_payload')->nullable();
            $table->string('payment_link', 355)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ramayanas');
    }
};
