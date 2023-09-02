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
    Schema::create('cart_items', function (Blueprint $table) {
      $table->charset = 'utf8mb4';
      $table->collation = 'utf8mb4_unicode_ci';
      
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
      $table->unsignedBigInteger('attr_id');
      $table->foreign('attr_id')->references('id')->on('attributes')->onDelete('CASCADE');
      $table->integer('quantity');
      $table->float('subtotal');
      $table->float('tax');
      $table->float('discount')->nullable();
      $table->float('total');
      $table->unsignedBigInteger('coupon_id')->nullable();
      $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('SET NULL');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
  */
  public function down(): void
  {
    Schema::dropIfExists('cart_items');
  }
};
