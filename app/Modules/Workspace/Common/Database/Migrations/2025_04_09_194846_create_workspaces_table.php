<?php

use App\Modules\Payment\Domain\Models\Payment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        Schema::create('workspaces', function (Blueprint $table) {

            $table->uuid('id')->primary();

            // $table->foreignUuid('organizaion_id')
            //     ->constrained('organizaions');

            $table->foreignUuid('user_organizaion_id')
                ->constrained('user_organization')->noActionOnDelete(); // делается для того, что бы знать какая организация и user в этой орагнизации создали workspace

            $table->string('name')->comment('Название workspace');
            $table->text('description');
            $table->boolean('is_active');


            $table->foreignUuid('payment_id')
                ->constrained('payments');


            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }



};
