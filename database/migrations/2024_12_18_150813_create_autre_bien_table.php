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
        Schema::create('autre_biens', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable();
            $table->integer("loyer")->nullable();
            $table->string("status");
            $table->integer("garantie")->nullable();
            $table->string("type");

            $table->unsignedBigInteger('id_galerie'); 

            $table->foreign('id_galerie') 
            ->references('id') 
            ->on('galeries') 
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autre_bien');
    }
};
