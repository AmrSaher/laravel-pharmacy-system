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
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('priority');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('governorate_id');

            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // $table->foreign('governorate_id')
            //     ->references('id')
            //     ->on('governorates')
            //     ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
