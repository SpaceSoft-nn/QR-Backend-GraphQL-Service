<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
    }


    public function down(): void
    {
        Schema::dropIfExists('personal_areas');
    }
};
