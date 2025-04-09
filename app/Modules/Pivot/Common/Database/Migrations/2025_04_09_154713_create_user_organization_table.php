<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('user_organization', function (Blueprint $table) {

            $table->id();

            $table->foreignUuid('user_id')
                ->constrained('users')->noActionOnDelete();


            $table->foreignUuid('organization_id')
                ->constrained('users')->noActionOnDelete();

            $table->unique(['user_id', 'organization_id']);

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('user_organization');
    }
};
