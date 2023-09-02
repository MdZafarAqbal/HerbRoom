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
    Schema::create('countries', function (Blueprint $table) {
      $table->charset = 'utf8mb4';
      $table->collation = 'utf8mb4_unicode_ci';

      $table->id();
      $table->string('name', 100)->unique();
      $table->string('capital', 100)->nullable();
      $table->string('iso_code')->nullable();
      $table->string('lang')->nullable();
      $table->string('currency')->nullable();
      $table->string('currency_symbol')->nullable();
      $table->integer('calling_code')->nullable();
      $table->string('tld')->nullable();
      $table->string('flag_icon')->nullable();
      $table->string('region')->nullable();
      $table->string('time_zone')->nullable();
      $table->string('date_format')->nullable();
      $table->enum('status', ['active', 'inactive'])->default('inactive');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
  */
  public function down(): void
  {
    Schema::dropIfExists('countries');
  }
};
