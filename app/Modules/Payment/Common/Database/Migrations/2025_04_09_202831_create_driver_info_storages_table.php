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
        Schema::create('driver_info_storages', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('key')->comment('Название ключа например API Key или Seecret Key');
            $table->string('value')->comment('Значение ключа');


            $table->foreignUuid('payment_method_id')->index()
                ->constrained('payment_methods')->noActionOnDelete();

            $table->foreignId('user_organization_id')->index()
                ->constrained('user_organization')->noActionOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_info_storages');
    }
};
