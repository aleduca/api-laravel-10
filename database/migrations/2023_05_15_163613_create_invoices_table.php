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
    Schema::create('invoices', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->string('type');
      $table->boolean('paid');
      $table->decimal('value', 10, 2);
      $table->datetime('payment_date')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('invoices');
  }
};
