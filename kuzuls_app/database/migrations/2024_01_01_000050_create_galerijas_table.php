<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('galerijas', function (Blueprint $table) {
            $table->id();

            $table->string('nosaukums', 200);
            $table->text('apraksts')->nullable();

            $table->foreignId('kategorija_id')->nullable()->constrained('kategorijas')->nullOnDelete();

            $table->boolean('publicets')->default(false);

            // Optional linkage to content (for your “saistita” fields)
            $table->enum('saistita_tips', ['nav','pasakumi','projekti','jaunumi'])->default('nav');
            $table->unsignedBigInteger('saistita_id')->nullable();

            $table->timestamps();

            $table->index(['publicets']);
            $table->index(['saistita_tips', 'saistita_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galerijas');
    }
};