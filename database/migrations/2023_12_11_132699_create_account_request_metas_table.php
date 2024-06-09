<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('filament-accounts.features.requests')){
            Schema::create('account_request_metas', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');

                $table->unsignedBigInteger('model_id')->nullable();
                $table->string('model_type')->nullable();

                $table->foreignId('account_request_id')->references('id')->on('account_requests')->onDelete('cascade');
                $table->string('key')->index();
                $table->json('value')->nullable();

                $table->boolean('is_approved')->default(0)->nullable();
                $table->datetime('is_approved_at')->nullable();

                $table->boolean('is_rejected')->default(0)->nullable();
                $table->datetime('is_rejected_at')->nullable();
                $table->text('rejected_reason')->nullable();

                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(config('filament-accounts.features.requests')) {
            Schema::dropIfExists('account_request_metas');
        }
    }
};
