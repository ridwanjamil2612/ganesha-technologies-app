<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brochures', function (Blueprint $t) {
            $t->string('thumb')->nullable()->after('file');
        });
    }

    public function down(): void
    {
        Schema::table('brochures', fn (Blueprint $t) => $t->dropColumn('thumb'));
    }
};
