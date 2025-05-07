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
        Schema::create('tariff_packages', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->increments('number_id')->unique()->comment('Номер тарифа для удобности');

            $table->string('name_tariff')
                ->nullable()
                ->unique()->comment("Название тарифа");

            $table->decimal('price', 10, 2);

            $table->integer('payment_limit')->comment('Лимит оплат к примеру максимум 50-100 оплат');

            $table->text('description', 10, 2)->comment('Описание тарифа');

            $table->integer('period')->comment("Количество дней активации: например 30 (1 месяц), 90 дней (3 месяца)");


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_tariff_packages_create');
    }
};
