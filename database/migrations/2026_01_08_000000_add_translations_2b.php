<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $t) {
            $t->string('title_en')->nullable()->after('title');
            $t->text('desc_en')->nullable()->after('desc');
        });
        Schema::table('sectors', function (Blueprint $t) {
            $t->string('name_en')->nullable()->after('name');
            $t->text('desc_en')->nullable()->after('desc');
        });
        Schema::table('process_steps', function (Blueprint $t) {
            $t->string('title_en')->nullable()->after('title');
            $t->text('desc_en')->nullable()->after('desc');
        });
        Schema::table('faqs', function (Blueprint $t) {
            $t->text('q_en')->nullable()->after('q');
            $t->text('a_en')->nullable()->after('a');
        });
        Schema::table('certifications', function (Blueprint $t) {
            $t->string('title_en')->nullable()->after('title');
            $t->text('desc_en')->nullable()->after('desc');
            $t->string('status_en')->nullable()->after('status');
        });
        Schema::table('standards', function (Blueprint $t) {
            $t->text('text_en')->nullable()->after('text');
        });
    }

    public function down(): void
    {
        Schema::table('services', fn (Blueprint $t) => $t->dropColumn(['title_en', 'desc_en']));
        Schema::table('sectors', fn (Blueprint $t) => $t->dropColumn(['name_en', 'desc_en']));
        Schema::table('process_steps', fn (Blueprint $t) => $t->dropColumn(['title_en', 'desc_en']));
        Schema::table('faqs', fn (Blueprint $t) => $t->dropColumn(['q_en', 'a_en']));
        Schema::table('certifications', fn (Blueprint $t) => $t->dropColumn(['title_en', 'desc_en', 'status_en']));
        Schema::table('standards', fn (Blueprint $t) => $t->dropColumn(['text_en']));
    }
};
