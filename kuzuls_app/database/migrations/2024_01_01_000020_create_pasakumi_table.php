<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pasakumi', function (Blueprint $table) {
            $table->id();

            $table->string('nosaukums', 200);
            $table->text('apraksts')->nullable();
            $table->date('norises_datums');
            $table->time('sakuma_laiks');
            $table->time('beigu_laiks')->nullable();
            $table->string('vieta', 200);

            $table->foreignId('kategorija_id')->nullable()->constrained('kategorijas')->nullOnDelete();

            $table->string('talrunis', 50)->nullable();
            $table->string('epasts', 190)->nullable();

            $table->string('attels', 255)->nullable(); // storage path

            $table->boolean('publicets')->default(false);

            $table->foreignId('izveidoja_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['publicets', 'norises_datums']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasakumi');
    }
};