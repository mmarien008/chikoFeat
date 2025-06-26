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
        Schema::create('loyer_apps', function (Blueprint $table) {
            $table->id();
            $table->integer("montant");
            $table->string("date");
            $table->string("statut");
            $table->unsignedBigInteger('id_locataire'); 
            $table->unsignedBigInteger('id_appartement'); 
         
            $table->foreign('id_locataire') // Définition de la clé étrangère
                  ->references('id') // Référence la colonne `id`
                  ->on('locataires') // Table cible : `roles`
                  ->onDelete('cascade');

            $table->foreign('id_appartement') // Définition de la clé étrangère
                  ->references('id') // Référence la colonne `id`
                  ->on('appartements') // Table cible : `roles`
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyer');
    }
};
