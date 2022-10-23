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
        Schema::create('admin',function (Blueprint $table){
            $table->id('id')->unique()->autoIncrement();
            $table->string('username',30)-> notNull()->unique();
            $table->string('password',128)->notNull();
            $table->string('email',30)->notNull()->unique();
            $table->string('remember_token',30)->nullable();
            $table->timestamp('last_login')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('last_change')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('sex');
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
        Schema::dropIfExists('admin');
    }
};
