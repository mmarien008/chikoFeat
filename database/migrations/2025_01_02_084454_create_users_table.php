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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 191)->nullable()->unique(); // Limite à 191 caractères
            $table->timestamp('email_verified_at')->nullable();
            $table->string('role', 50)->default('user'); // Limite raisonnable pour 'role'
            $table->string('phone', 20)->unique(); // Numéro de téléphone limité à 20 caractères
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
