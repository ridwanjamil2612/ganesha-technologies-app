<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $t) {
                $t->id();
                $t->string('name')->unique();
                $t->string('label');
                $t->json('permissions')->nullable();
                $t->boolean('is_system')->default(false);
                $t->timestamps();
            });
        }

        $now = now();
        if (DB::table('roles')->count() === 0) {
            DB::table('roles')->insert([
                ['name' => 'administrator', 'label' => 'Administrator', 'permissions' => json_encode(['*']), 'is_system' => true, 'created_at' => $now, 'updated_at' => $now],
                ['name' => 'editor', 'label' => 'Editor', 'permissions' => json_encode(['content', 'messages.view']), 'is_system' => false, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        if (! Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $t) {
                $t->unsignedBigInteger('role_id')->nullable()->after('email');
            });
        }

        $adminId = DB::table('roles')->where('name', 'administrator')->value('id');
        $editorId = DB::table('roles')->where('name', 'editor')->value('id');

        // Pemetaan dari sistem peran lama (kolom string 'role') bila ada
        if (Schema::hasColumn('users', 'role')) {
            DB::table('users')->where('role', 'editor')->update(['role_id' => $editorId]);
        }
        // Sisanya (termasuk pemilik saat ini) jadi Administrator
        DB::table('users')->whereNull('role_id')->update(['role_id' => $adminId]);
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', fn (Blueprint $t) => $t->dropColumn('role_id'));
        }
        Schema::dropIfExists('roles');
    }
};
