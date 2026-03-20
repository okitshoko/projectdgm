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
        Schema::create('visas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->onDelete('cascade'); // Lie le visa à un pays
            $table->string('nom_etranger');
            $table->string('numero_passeport')->unique();
            $table->string('type_visa');
            $table->date('date_entree');
            $table->date('date_expiration');
            $table->string('email_contact');
            $table->string('telephone_contact');
            $table->string('statut')->default('En attente'); // Ex: En attente, Approuvé, Rejeté
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visas');
    }
};
