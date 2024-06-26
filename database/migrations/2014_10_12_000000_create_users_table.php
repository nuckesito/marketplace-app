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
      $table->id();
      $table->string('name');
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('profile_photo_path', 2048)->nullable();
      $table->rememberToken();
      $table->timestamps();
      $table->string('rol_id')/* ->default('2') */->nullable();
      $table->unsignedBigInteger('membresia_id')->default(1);

      $table->foreign('membresia_id')
      ->references('id')->on('membresias')
      ->onDelete('cascade')
      ->onUpdate('cascade');
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
