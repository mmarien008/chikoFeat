<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::table('revenu_externes', function (Blueprint $table) {
        $table->decimal('montant', 20, 2)->change();
    });
}

public function down()
{
    Schema::table('revenu_externes', function (Blueprint $table) {
        $table->float('montant')->change();
    });
}

};
