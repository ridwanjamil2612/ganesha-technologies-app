<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->string('label')->nullable();
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('stats'); }
};
