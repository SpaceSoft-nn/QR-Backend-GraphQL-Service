<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('name');
            $table->boolean('active')->default(false);
            $table->string('driver')->comment('Провайдер');

            $table->foreignUuid('payment_id')->index()
                ->constrained('payments')->noActionOnDelete(); //способ оплаты у платежа QIWI, YOUCASSA, PAYPAL, BITCOIN


            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('payment_methods_tabl');
    }
};
