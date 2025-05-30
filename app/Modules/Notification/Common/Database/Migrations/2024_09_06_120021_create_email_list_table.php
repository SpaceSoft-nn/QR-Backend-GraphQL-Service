<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('email_lists', function (Blueprint $table) {

            $table->uuid('id')->primary(); // Используем UUID как первичный ключ
            $table->string('value')->unique()->comment('Почта');
            $table->boolean('status')->default(false)->comment('Статус активации');
            $table->timestamps();

        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('email_list');
    }
};
