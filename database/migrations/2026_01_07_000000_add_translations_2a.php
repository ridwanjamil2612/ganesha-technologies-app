<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('tagline_en')->nullable()->after('tagline');
            $table->text('desc_en')->nullable()->after('desc');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
            $table->string('segment_en')->nullable()->after('segment');
            $table->text('desc_en')->nullable()->after('desc');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('excerpt_en')->nullable()->after('excerpt');
            $table->json('body_en')->nullable()->after('body');
        });
    }

    public function down(): void
    {
        Schema::table('settings', fn (Blueprint $t) => $t->dropColumn(['tagline_en', 'desc_en']));
        Schema::table('products', fn (Blueprint $t) => $t->dropColumn(['name_en', 'segment_en', 'desc_en']));
        Schema::table('news', fn (Blueprint $t) => $t->dropColumn(['title_en', 'excerpt_en', 'body_en']));
    }
};
