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
        Schema::create('transactions', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->uuid('nubmer_uuid')->comment('значение транзакции');


            $table->boolean('status')->comment('статус транзакции panding, close и т.д');
            $table->decimal('amount', 10,2);

            $table->foreignUuid('workspace_id')->index()
                ->constrained('workspaces')->noActionOnDelete();
            $table->foreignUuid('qr_code_id')->index()
                ->constrained('qr_codes')->noActionOnDelete();

            $table->string('type_product')->nullable()
                ->comment('необязательное поле - типа продукта (услуга, товар) ');

            $table->string('count_product')->nullable()
                ->comment('Количество товара');

            $table->string('name_product')->nullable();


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
