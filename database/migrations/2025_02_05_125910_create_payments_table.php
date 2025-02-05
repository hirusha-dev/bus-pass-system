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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buss_pass_id')->constrained('bus_passes')->onDelete('cascade');
            $table->enum('payment_method', ['credit_card', 'cash', 'online']);
            $table->decimal('amount', 10, 2);
            $table->dateTime('payment_date');
            $table->enum('status', ['paid', 'pending', 'failed'])->default('pending');
            $table->string('payment_slip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
