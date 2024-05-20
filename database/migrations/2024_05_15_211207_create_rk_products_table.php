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
        Schema::create('rk_products', function (Blueprint $table) {

            $table->bigInteger('ident')->unsigned()->unique();
            $table->bigInteger('code')->unsigned();
            $table->string('name');
            $table->float('price')->unsigned()->nullable();
            $table->longText('instruct')->nullable();
            $table->bigInteger('parent_ident')->unsigned();
            $table->integer('position')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rk_products');
    }
};