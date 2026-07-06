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
        Schema::create('user_follows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follower_id');
            $table->foreign('follower_id')->references('id')->on('users');
            $table->unsignedBigInteger('following_id');
            $table->foreign('following_id')->references('id')->on('users');
            $table->enum('status' , [1,2,3]) ->comment('1=>pending , 2=>accept , 3=>reject')->default(1);
            $table->unique(['follower_id', 'following_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_follows');
    }
};
