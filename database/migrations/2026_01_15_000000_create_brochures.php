<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('brochures')) {
            Schema::create('brochures', function (Blueprint $t) {
                $t->id();
                $t->string('title');          // judul brosur (input manual)
                $t->string('file')->nullable(); // path file PDF di storage
                $t->integer('sort')->default(0);
                $t->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('brochures');
    }
};
