<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lapas', function (Blueprint $table) {
            $table->id();

            $table->string('slug', 120)->unique();
            $table->string('virsraksts', 200);
            $table->longText('saturs');

            $table->foreignId('kategorija_id')->nullable()->constrained('kategorijas')->nullOnDelete();

            $table->boolean('publicets')->default(true);

            $table->foreignId('izveidoja_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['publicets', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapas');
    }
};