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
        Schema::create('question',function (Blueprint $table){
            $table->id('id')->unique()->autoIncrement();
            $table->string('qid')->unique();
            $table->string('name',20)->notNULL();
            $table->string('comes',30);
            $table->integer('score');
            $table->string('path');
            $table->string('class');
            $table->string('flag');
            $table->integer('now_exit');
            $table->string('port')->nullable();
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
        Schema::dropIfExists('question');
    }
};
