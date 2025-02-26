<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('account')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('loginBy')->default('email')->nullable();
            $table->text('address')->nullable();
            $table->string('lang', 10)->nullable();

            // Login
            $table->string('password')->nullable();
            $table->string('otp_code')->nullable();
            $table->dateTime('otp_activated_at')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->longText('agent')->nullable();
            $table->string('host')->nullable();

            // Options
            $table->boolean('is_login')->default(0)->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_notification_active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
