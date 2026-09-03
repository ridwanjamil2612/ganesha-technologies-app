<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->string('image')->nullable()->after('slug');
        });

        // Isi slug untuk produk yang sudah ada
        foreach (\App\Models\Product::all() as $p) {
            if (! empty($p->slug)) {
                continue;
            }
            $base = Str::slug($p->name ?: ($p->code ?: 'produk-' . $p->id));
            $slug = $base;
            $i = 2;
            while (\App\Models\Product::where('slug', $slug)->where('id', '!=', $p->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $p->slug = $slug;
            $p->save();
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['slug', 'image']);
        });
    }
};
