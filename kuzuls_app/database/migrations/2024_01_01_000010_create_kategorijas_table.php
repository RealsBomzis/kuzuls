<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategorijas', function (Blueprint $table) {
            $table->id();
            $table->string('nosaukums', 120)->unique();
            $table->enum('tips', ['visiem','pasakumi','projekti','jaunumi','galerijas','lapas'])->default('visiem');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategorijas');
    }
};