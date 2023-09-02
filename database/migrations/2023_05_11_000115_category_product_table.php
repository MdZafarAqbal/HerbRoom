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
    Schema::create('category_product', function (Blueprint $table) {
      $table->charset = 'utf8mb4';
      $table->collation = 'utf8mb4_unicode_ci';
      
      $table->id();
      $table->unsignedBigInteger('product_id');
      $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
      $table->unsignedBigInteger('cat_id')->nullable();
      $table->foreign('cat_id')->references('id')->on('categories')->onDelete('CASCADE');
      $table->unsignedBigInteger('subcat_id')->nullable();
      $table->foreign('subcat_id')->references('id')->on('sub_categories')->onDelete('SET NULL');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('category_product');
  }
};
