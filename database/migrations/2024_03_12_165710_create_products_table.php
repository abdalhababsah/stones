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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 255);
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->string('qrcode', 255)->nullable();
            $table->enum('category_type', ['featured', 'hot', 'new'])->nullable();
            $table->unsignedBigInteger('category_id');

            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
