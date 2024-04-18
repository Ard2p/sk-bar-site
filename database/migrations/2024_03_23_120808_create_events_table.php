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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('banner')->nullable();
            $table->string('gallery')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('event_start');
            $table->dateTime('guest_start');
            $table->boolean('recommendation')->default(false);
            $table->string('status');
            $table->string('age_limit');
            $table->bigInteger('place_id')->unsigned();
            $table->bigInteger('genre_id')->unsigned()->nullable();
            $table->string('tickets_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
