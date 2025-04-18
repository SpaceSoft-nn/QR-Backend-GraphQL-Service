<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    { //таблица нужно для выбора, к примеру банки, или платежные агрегаты, или внешние сервисы, где уже будет выбираться конкретная платежка
        Schema::create('payments', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->increments('number_id')->unique()->comment('Номер payment для удобности');


            $table->boolean('status');

            $table->string('name')->index('name_payment')->comment('название платежного метода');


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

