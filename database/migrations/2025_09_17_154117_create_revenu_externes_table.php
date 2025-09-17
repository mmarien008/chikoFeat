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
        Schema::create('revenu_externes', function (Blueprint $table) {
            $table->id();
            $table->string("motif");
            $table->float("montant");
            $table->date("date");

            // Définir la colonne user_id AVANT la clé étrangère
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            // Définir la clé étrangère
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenu_externes');
    }
};
