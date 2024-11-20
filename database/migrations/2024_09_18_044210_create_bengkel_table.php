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
        // up : membuat, dijalankan ketika "php artisan migrate"
        Schema::create('bengkels', function (Blueprint $table) {
            // membuat primary key dengan nama id dan sifatnya AI(auto increment)
            $table->id();
            // $table->tipedata('namafield');
            $table->enum('type', ['Oli', 'Ban', 'Fix']);
            $table->string('name');
            $table->integer('price');
            $table->integer('stock');
            // membuat created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bengkels');
    }
};
