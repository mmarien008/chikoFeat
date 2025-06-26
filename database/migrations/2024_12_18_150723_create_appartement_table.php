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
        Schema::create('appartements', function (Blueprint $table) {
            $table->id();
            $table->string("numero");
            $table->string("status");

            $table->integer("loyer")->nullable();
            $table->integer("garantie")->nullable();
            
            $table->unsignedBigInteger('id_immeuble'); 

            $table->foreign('id_immeuble') 
            ->references('id') 
            ->on('immeubles') 
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appartement');
    }
};
