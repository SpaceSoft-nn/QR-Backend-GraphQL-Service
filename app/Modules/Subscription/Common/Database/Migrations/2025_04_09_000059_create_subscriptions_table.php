<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('plan_name');

            $table->decimal('price', 10, 2);

            $table->date('expires_at')->default('9999-12-31'); //устанавливаем дефолтное недостижмое время для стандартного Subscription

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
