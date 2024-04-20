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
        Schema::table('seo', function (Blueprint $table) {
            $table->bigInteger('model_id')->nullable()->unsigned();
            $table->string('model_type')->nullable();
        });
        // Schema::create('seo', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('model_id');
        //     $table->string('model_type');
        //     $table->string('url')->unique();
        //     $table->string('title');
        //     $table->text('description')->nullable();
        //     $table->text('keywords')->nullable();
        //     $table->text('text')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo', function (Blueprint $table) {
            $table->dropColumn(['model_id', 'model_type']);
        });
    }
};
