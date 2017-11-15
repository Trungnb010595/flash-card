<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserstbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email',30)->unique();
            $table->string('password',30);
            $table->boolean('role_id')->default(0);
            $table->string('slug',50);
            $table->string('name',50);
            $table->string('first_name',30);
            $table->string('last_name',30);
            $table->string('avatar',50);
            $table->string('gender',5);
            $table->string('phone',11);
            $table->date('birthday');
            $table->string('fb_id',30);
            $table->string('gg_id',30);
            $table->string('status')->default(0);
            $table->rememberToken();
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
