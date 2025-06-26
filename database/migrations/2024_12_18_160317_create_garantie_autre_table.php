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
        Schema::create('garantie_autres', function (Blueprint $table) {
            $table->id();
         
            $table->integer("montant_retirer");
            $table->integer("montant_ajouter");

            $table->integer("montant_initiale");
            $table->integer("montant");
            $table->string("date");

            $table->unsignedBigInteger('id_locataire'); 
            $table->unsignedBigInteger('id_autre_bien'); 
         
            $table->foreign('id_locataire') 
                  ->references('id') 
                  ->on('locataires') 
                  ->onDelete('cascade');

            $table->foreign('id_autre_bien') 
                  ->references('id') 
                  ->on('autre_biens')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garantie_autre');
    }
};
