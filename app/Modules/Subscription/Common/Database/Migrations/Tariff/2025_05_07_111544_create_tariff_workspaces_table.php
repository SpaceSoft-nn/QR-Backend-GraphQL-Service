<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tariff_workspaces', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->increments('number_id')->unique()->comment('Номер тарифа для удобности');

            $table->string('name_tariff')
                ->nullable()
                ->unique()->comment("Название тарифа");

            $table->decimal('price', 10, 2);
            $table->decimal('price_discount', 10, 2)->nullable()->comment('Сумма подсчета со скидкой');
            
            $table->unsignedSmallInteger('count_workspace')->comment('Количество рабочих мест');
            $table->unsignedSmallInteger('discount')->default(0)->count("Скидка для данного тарифа");

            $table->text('description', 10, 2)->nullable()->comment('Описание тарифа');

            $table->integer('period')->comment("Количество дней активации: например 30 (1 месяц), 90 дней (3 месяца)");



            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tariff_workspaces');
    }
};
