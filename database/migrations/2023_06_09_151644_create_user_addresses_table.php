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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('flat_number');
            $table->integer('floor_number');
            $table->integer('building_number');
            $table->string('street_name');
            $table->string('area_id');
            $table->boolean('is_main')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('governorate_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('governorate_id')
                ->references('id')
                ->on('governorates')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
