<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->unique();
            $table->string('author');
            $table->string('publisher');
            $table->year('years');
            $table->string('isbn')->unique();
            $table->string('category');
            $table->text('description')->nullable(); //tidak wajib diisi
            $table->integer('stock')->default(0);
            $table->string('image')->nullable(); //tidak wajib
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
