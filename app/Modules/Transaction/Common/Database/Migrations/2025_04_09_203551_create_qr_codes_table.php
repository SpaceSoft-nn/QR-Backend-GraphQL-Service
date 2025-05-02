<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('qr_url')->comment('Ссылка на url QR CБП');
            $table->binary('content_image_base64')->comment("Qr картинка в формате base64");


            $table->string('qr_type')->comment("Тип QR: dynamic, static");

            $table->string('ttl')->nullable()->comment("Время жизни СБП - только для Динамических qr");
            $table->string('width')->nullable()->comment("Ширина картинки СБП");
            $table->string('height')->nullable()->comment("Высота картинки СБП");


            $table->foreignUuid('transaction_id')->index()
                ->constrained('transactions')->noActionOnDelete();


            $table->string('name_product')->nullable();
            $table->decimal('amount', 9, 2)->nullable();


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
