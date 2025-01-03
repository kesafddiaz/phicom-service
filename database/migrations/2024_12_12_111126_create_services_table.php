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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->text('service_details');
            $table->enum('status', ['MENUNGGU', 'SEDANG_DIKERJAKAN', 'SELESAI', 'DIAMBIL']);
            $table->decimal('total', 10, 2)->nullable();
            $table->string('services_id')->unique()->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
