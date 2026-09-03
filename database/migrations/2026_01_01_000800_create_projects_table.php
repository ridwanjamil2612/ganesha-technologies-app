<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->string('sector')->nullable();
            $table->string('product')->nullable();
            $table->string('capacity')->nullable();
            $table->integer('year')->nullable();
            $table->string('location')->nullable();
            $table->string('tile')->default('pinwheel');
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('projects'); }
};
