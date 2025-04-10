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
        Schema::create('users', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('password');


            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('role')->comment('Роль user enum: admin, cassier, manager');
            $table->integer('permission')->default(15)->comment('Таблица доступа');

            $table->boolean('active')->default(false)->comment('Активирован ли user');
            $table->boolean('auth')->default(false)->comment('Активирован ли через подтврждения email/phone');

            $table->foreignUuid('personal_area_id')->nullable()
                ->constrained('personal_areas');

            $table->foreignUuid('email_id')
                ->constrained('email_lists');
            $table->foreignUuid('phone_id')->nullable()
                ->constrained('phone_lists');


            $table->rememberToken();
            $table->timestamps();

        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
