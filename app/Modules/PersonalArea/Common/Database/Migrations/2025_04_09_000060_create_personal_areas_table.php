<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('personal_areas', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->decimal('balance', 10, 2);

            $table->timestamps();

        });

        // Добавляем CHECK-констрейнт к колонке balance
        DB::statement('ALTER TABLE personal_areas ADD CONSTRAINT balance_check CHECK (balance >= 0)');
    }


    public function down(): void
    {
        Schema::dropIfExists('personal_areas');
    }
};
