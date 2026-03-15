<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('satura_saites', function (Blueprint $table) {
            $table->id();

            // Source
            $table->string('avots_tips', 50);          // e.g. jaunumi/pasakumi/projekti/lapas
            $table->unsignedBigInteger('avots_id');

            // Target
            $table->string('merkis_tips', 50);         // e.g. jaunumi/pasakumi/projekti/lapas
            $table->unsignedBigInteger('merkis_id');

            // ✅ THIS is what your seeder expects
            $table->string('tips', 30);                // e.g. "automatiskais" / "manuals"

            $table->unsignedInteger('atbilstibas_punkti')->default(0);  // score, your seeder uses 60
            $table->string('review_status', 20)->default('pending');    // pending/approved/rejected

            $table->foreignId('izveidoja_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['avots_tips', 'avots_id']);
            $table->index(['merkis_tips', 'merkis_id']);
            $table->index(['review_status', 'tips']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satura_saites');
    }
};