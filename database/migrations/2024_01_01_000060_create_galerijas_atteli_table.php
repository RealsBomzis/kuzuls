<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('galerijas_atteli', function (Blueprint $table) {
            $table->id();

            $table->foreignId('galerija_id')->constrained('galerijas')->cascadeOnDelete();

            $table->string('fails_cels', 255); // storage path on public disk
            $table->string('alt_teksts', 200)->nullable();
            $table->unsignedInteger('seciba')->default(0);

            $table->timestamps();

            $table->index(['galerija_id', 'seciba']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galerijas_atteli');
    }
};