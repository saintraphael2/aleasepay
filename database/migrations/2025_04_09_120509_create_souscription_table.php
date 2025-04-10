<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('souscription', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->string('profil');
            $table->string('souscripteur')->nullable();
            $table->string('email')->nullable();
            $table->date('date_souscription')->nullable();
            $table->string('compte_cree')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('souscription');
    }
};
