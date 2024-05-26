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
        Schema::create('rk_categories', function (Blueprint $table) {

            $table->bigInteger('ident')->unsigned()->unique();
            $table->bigInteger('code')->unsigned();
            $table->string('name');
            $table->integer('position')->unsigned()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rk_categories');
    }
};
