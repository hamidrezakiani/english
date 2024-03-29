<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('mobile')->unique();
            $table->string('name');
            $table->boolean('new_user')->default(1);
            $table->string('invited_by');
            $table->string('ip');
            $table->boolean('mobileVerify')->default(0);
            $table->boolean('payStatus')->default(false);
            $table->string('api_token', 80);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
