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
    Schema::create('coupons', function (Blueprint $table) {
      $table->charset = 'utf8mb4';
      $table->collation = 'utf8mb4_unicode_ci';
      
      $table->id();
      $table->string('code')->unique();
      $table->enum('type', ['fixed', 'percent'])->default('percent');
      $table->decimal('value');
      $table->float('threshold')->nullable();
      $table->enum('effect', ['product', 'attribute', 'category', 'subcategory', 'user', 'all']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('coupons');
  }
};
