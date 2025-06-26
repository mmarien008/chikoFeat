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
        Schema::create('loyer_autres', function (Blueprint $table) {
            $table->id();
            $table->integer("montant");
            $table->string("date");
            $table->string("statut");
            
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
        Schema::dropIfExists('loyer_autre');
    }
};
