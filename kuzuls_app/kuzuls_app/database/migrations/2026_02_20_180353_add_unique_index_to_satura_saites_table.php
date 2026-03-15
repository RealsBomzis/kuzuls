<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('satura_saites', function (Blueprint $table) {
            $table->unique(
                ['avots_tips','avots_id','merkis_tips','merkis_id','tips'],
                'satura_saites_unique_link'
            );
        });
    }

    public function down(): void
    {
        Schema::table('satura_saites', function (Blueprint $table) {
            $table->dropUnique('satura_saites_unique_link');
        });
    }
};