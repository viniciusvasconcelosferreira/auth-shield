<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->string('postal_code');
            $table->string('address');
            $table->string('street')->nullable();
            $table->string('number');
            $table->string('neighborhood')->nullable();
            $table->string('complement')->nullable();
            $table->string('reference')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->boolean('set_default')->default(0);
            $table->unsignedBiginteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresses');
    }
};
