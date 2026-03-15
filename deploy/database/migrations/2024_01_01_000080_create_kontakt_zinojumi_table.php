<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kontakt_zinojumi', function (Blueprint $table) {
            $table->id();

            $table->string('vards', 120);
            $table->string('epasts', 190);
            $table->string('tema', 200)->nullable();
            $table->text('zinojums');

            $table->enum('statuss', ['jauns','apstradats'])->default('jauns');

            $table->timestamps();

            $table->index(['statuss', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontakt_zinojumi');
    }
};