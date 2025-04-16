<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->unsignedBigInteger('profil')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('racine', 6)->nullable();
            $table->tinyInteger('etat')->nullable()->default(1);
            $table->rememberToken(); // Génère un champ string(100) nullable
            $table->integer('validation_code')->default(0)->nullable();
            $table->timestamps();

            // Clé étrangère vers la table profils
            $table->foreign('profil')->references('id')->on('profil')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}