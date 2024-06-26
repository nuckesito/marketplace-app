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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_pago');
            $table->double('monto');

            $table->unsignedBigInteger('anuncio_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('stripe_payment_id')->nullable();
            $table->string('paypal_payment_id')->nullable();
            $table->unsignedBigInteger('membresia_id')->nullable();
            $table->foreign('anuncio_id')
                ->references('id')
                ->on('anuncios')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('membresia_id')
                ->references('id')
                ->on('membresias')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
