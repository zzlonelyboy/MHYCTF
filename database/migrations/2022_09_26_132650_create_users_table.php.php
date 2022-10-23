<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users',function (Blueprint $table){
            $table->id('id')->unique()->autoIncrement();
            $table->string('username',30)-> notNull()->unique();
            $table->string('password',128)->notNull();
            $table->string('school',20)->default('blblcollege');
            $table->string('try_question',)->default('a:0:{}');
            $table->string('slove',)->default('a:0:{}');
            $table->string('email',25)->notNull()->unique();
            $table->string('remember_token',30)->nullable();
            $table->dateTime('last_login')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('sex')->default(0);
            $table->string('team')->default('null');
            $table->integer('score')->default(0);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
