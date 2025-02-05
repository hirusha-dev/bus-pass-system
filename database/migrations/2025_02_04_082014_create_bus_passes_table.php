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
        Schema::create('bus_passes', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('nic')->unique();
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->string('start_location');
            $table->string('end_location');
            $table->integer('distance');
            $table->string('province');
            $table->string('district');
            $table->enum('pass_type', ['student', 'employee']);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('amount', 10, 2);
            $table->string('qr_code')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_passes');
    }
};
