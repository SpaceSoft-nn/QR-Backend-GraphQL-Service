<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('owner_id')
                ->constrained('users')->noActionOnDelete();

            $table->string('name');
            $table->string('address');

            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->boolean('remuved')->default(false)->comment('Статус Закрыт/Открыт');
            $table->string('website')->nullable();
            $table->string('type')->comment('Тип оргиназции: ООО, ИП и т.д');
            $table->text('description')->nullable();
            $table->string('okved')->comment('вид экономической деятельности')->nullable();
            $table->dateTime('founded_date');

            $table->string('inn', 12)->comment('Инн у ООО/ИП');
            $table->string('kpp' , 9)->nullable()->comment('КПП - Только у организации');
            $table->string('registration_number', 15)->unique()->comment('ОГРН и ОГРНИП');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizaions');
    }
};
