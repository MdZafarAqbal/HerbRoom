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
    Schema::create('states', function (Blueprint $table) {
      $table->charset = 'utf8mb4';
      $table->collation = 'utf8mb4_unicode_ci';
      
      $table->id();
      $table->string('name', 100);
      $table->unsignedBigInteger('country_id');
      $table->foreign('country_id')->references('id')->on('countries')->onDelete('CASCADE');
      $table->enum('status', ['active', 'inactive'])->default('inactive');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
  */
  public function down(): void
  {
    Schema::dropIfExists('states');
  }
};
