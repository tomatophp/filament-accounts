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
        if(config('filament-accounts.features.contacts')){
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('type')->default('contact')->nullable();
                $table->string('status')->default('pending')->nullable();
                $table->string('name')->index();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('subject');
                $table->text('message');
                $table->boolean('active')->default(1)->nullable();
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
        if(config('filament-accounts.features.contacts')) {
            Schema::dropIfExists('contacts');
        }
    }
};
