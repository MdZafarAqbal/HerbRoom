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
    Schema::create('cancel_items', function (Blueprint $table) {
      $table->charset = 'utf8mb4';
      $table->collation = 'utf8mb4_unicode_ci';
      
      $table->id();
      $table->unsignedBigInteger('order_id');
      $table->foreign('order_id')->references('id')->on('orders')->onDelete('CASCADE');
      $table->unsignedBigInteger('attr_id')->nullable();
      $table->foreign('attr_id')->references('id')->on('attributes')->onDelete('SET NULL');
      $table->integer('quantity');
      $table->float('discount')->nullable();
      $table->float('total');
      $table->string('reason')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
  */
  public function down(): void
  {
    Schema::dropIfExists('cancel_items');
  }
};
