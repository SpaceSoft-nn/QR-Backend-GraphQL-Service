<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('balance_logs', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('personal_area_id')->index()
                ->constrained('personal_areas');

            $table->decimal('balance_before', 10, 2)->comment('баланс до совершения операции');
            $table->decimal('balance_after', 10, 2)->comment('баланс после совершения операции');
            $table->decimal('amount', 10, 2)->comment('величина изменения (можно вычислять как разницу между balance_after и balance_before, для удобства)');

            $table->string('operation')->comment('тип операции (например, пополнение, списание, корректировка, установка первого баланса) ');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('balance_logs');
    }
};
