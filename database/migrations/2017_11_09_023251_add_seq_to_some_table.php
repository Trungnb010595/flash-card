<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeqToSomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table){
            $table->integer('seq')->default(99);
        });

        Schema::table('permissions', function (Blueprint $table){
            $table->integer('seq')->default(99);
        });

        Schema::table('courses', function (Blueprint $table){
            $table->integer('seq')->default(999);
        });

        Schema::table('lessons', function (Blueprint $table){
            $table->integer('seq')->default(99);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
