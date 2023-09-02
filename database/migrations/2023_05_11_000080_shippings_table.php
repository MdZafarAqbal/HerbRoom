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
    Schema::create('shippings', function (Blueprint $table) {
      $table->charset = 'utf8mb4';
      $table->collation = 'utf8mb4_unicode_ci';
      
      $table->id();
      $table->unsignedBigInteger('order_id')->nullable();
      $table->foreign('order_id')->references('id')->on('orders')->onDelete('CASCADE');
      $table->string('awb_no')->nullable();
      $table->string('fname')->nullable();
      $table->string('lname')->nullable();
      $table->string('cname')->nullable();
      $table->unsignedBigInteger('trn_no')->nullable();
      $table->string('phone');
      $table->string('altphone')->nullable();
      $table->longText('address');
      $table->unsignedBigInteger('city_id')->nullable();
      $table->foreign('city_id')->references('id')->on('cities')->onDelete('SET NULL');
      $table->string('landmark')->nullable();
      $table->enum('status', ['ordered', 'processed', 'shipped', 'delivered'])->default('ordered');
      $table->date('ordered')->nullable();
      $table->date('processed')->nullable();
      $table->date('shipped')->nullable();
      $table->date('delivered')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
      Schema::dropIfExists('shippings');
  }
};
