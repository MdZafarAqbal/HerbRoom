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
    Schema::create('users', function (Blueprint $table) {
      $table->charset = 'utf8mb4';
      $table->collation = 'utf8mb4_unicode_ci';

      $table->id();
      $table->string('fname', 100)->nullable();
      $table->string('lname', 100)->nullable();
      $table->string('cname', 100)->nullable();
      $table->unsignedBigInteger('trn_no')->unique()->nullable();
      $table->string('email', 100)->unique();
      $table->string('password');
      $table->enum('type', ['admin', 'manager', 'user'])->default('user');
      $table->unsignedBigInteger('coupon_id')->nullable();
      $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('SET NULL');
      $table->rememberToken()->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->enum('status', ['active', 'inactive'])->default('active');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
  */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
