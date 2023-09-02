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
      /**
       * Run the migrations.
       *
       * @return void
      */
      Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        $table->unsignedBigInteger('product_id')->nullable();
        $table->foreign('product_id')->references('id')->on('products')->onDelete('CASCADE');
        $table->tinyInteger('rating')->default(1);
        $table->text('review')->nullable();
        $table->enum('status',['active', 'inactive'])->default('active');
        $table->timestamps();
      });
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
      Schema::dropIfExists('reviews');
    }
};
