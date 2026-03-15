<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jaunumi', function (Blueprint $table) {
            $table->id();

            $table->string('virsraksts', 200);
            $table->string('ievads', 255)->nullable();
            $table->longText('saturs');

            $table->date('publicesanas_datums')->nullable();

            $table->foreignId('kategorija_id')->nullable()->constrained('kategorijas')->nullOnDelete();

            $table->boolean('publicets')->default(false);

            $table->foreignId('izveidoja_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['publicets', 'publicesanas_datums']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jaunumi');
    }
};