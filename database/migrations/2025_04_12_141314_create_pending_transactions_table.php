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
            $table->string('reference')->unique();
            $table->string('type'); // Exemple: CNSS, OTR.
            $table->string('compte');
            $table->decimal('montant', 15, 2);
            $table->string('etat')->default('en_attente'); // en_attente, validée, rejetée
            $table->text('description')->nullable();
            $table->date('date_transaction')->nullable();
            $table->unsignedBigInteger('initiated_by'); // Clé étrangère vers users
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
