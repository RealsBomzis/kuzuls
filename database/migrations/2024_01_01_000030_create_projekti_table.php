<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projekti', function (Blueprint $table) {
            $table->id();

            $table->string('nosaukums', 200);
            $table->text('apraksts')->nullable();

            $table->enum('statuss', ['planots','aktivs','pabeigts'])->default('planots');

            $table->date('sakuma_datums')->nullable();
            $table->date('beigu_datums')->nullable();

            $table->foreignId('kategorija_id')->nullable()->constrained('kategorijas')->nullOnDelete();

            $table->boolean('publicets')->default(false);

            $table->foreignId('izveidoja_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['publicets', 'sakuma_datums']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projekti');
    }
};