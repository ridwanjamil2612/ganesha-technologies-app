<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('user_id')->nullable();
                $t->string('user_name')->nullable();  // disimpan agar tetap terbaca walau user dihapus
                $t->string('action', 30);             // login, logout, create, update, delete, dll
                $t->string('module')->nullable();     // produk, berita, pengguna, dll
                $t->string('description')->nullable();
                $t->string('ip', 45)->nullable();
                $t->timestamp('created_at')->nullable();
                $t->index(['created_at']);
                $t->index(['action']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
