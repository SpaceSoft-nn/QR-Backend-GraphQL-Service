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

            $table->boolean('status');

            // $table->uuid('number_uuid')->comment('номер payment');
            $table->string('name')->index('name_payment')->comment('название платежного метода');
            // $table->string('driver')->nullable()->comment('название драйвера для удобности');


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

