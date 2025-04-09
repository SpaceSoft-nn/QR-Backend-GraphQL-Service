<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('user_personal_area', function (Blueprint $table) {

            $table->id();

            $table->foreignUuid('user_id')
                ->constrained('users')->noActionOnDelete();


            $table->foreignUuid('personal_area_id')
                ->constrained('personal_areas')->noActionOnDelete();

            $table->unique(['user_id', 'personal_area_id']);

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('user_personal_area');
    }
};
