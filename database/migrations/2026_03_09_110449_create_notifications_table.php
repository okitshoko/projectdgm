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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visa_id')->constrained()->onDelete('cascade'); // Plus propre
            $table->string('type_alerte'); 
            $table->string('statut_envoi')->default('envoyé'); // Pour savoir si Gmail/SMS a fonctionné
            $table->dateTime('date_envoi');
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
