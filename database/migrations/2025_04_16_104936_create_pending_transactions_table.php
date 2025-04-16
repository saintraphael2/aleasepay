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
        Schema::create('pending_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('type'); 
            $table->string('compte');
            $table->string('montant');
            $table->string('montant_ttc');
            $table->string('etat')->default('en_attente'); 
            $table->text('description')->nullable();
            $table->date('date_transaction')->nullable();
            $table->unsignedBigInteger('initiated_by'); // Clé étrangère vers users
            $table->string('contribuable')->nullable();
            $table->string('numero_employeur')->nullable();
            $table->string('reference_transac')->nullable();
            $table->timestamps(); // created_at pour la soumission, updated_at pour les mises à jour

            
            $table->foreign('initiated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_transactions');
    }
};
