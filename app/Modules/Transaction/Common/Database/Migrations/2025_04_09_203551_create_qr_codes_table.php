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
        Schema::create('qr_codes', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('qr_url');
            $table->string('name_product')->nullable();

            $table->foreignUuid('transaction_id')->index()
                ->constrained('transactions')->noActionOnDelete();

            $table->decimal('amount')->nullable();


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
