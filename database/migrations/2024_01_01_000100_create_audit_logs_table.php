<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // ✅ match your code
            $table->string('darbiba', 150);
            $table->string('objekta_tips', 190)->nullable();
            $table->unsignedBigInteger('objekta_id')->nullable();

            $table->string('ip_adrese', 45)->nullable();
            $table->string('lietotaja_agents', 255)->nullable();

            $table->json('papildu_dati')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['objekta_tips', 'objekta_id']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};