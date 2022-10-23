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
        Schema::create('team',function (Blueprint $table){
            $table->id('id')->unique()->autoIncrement();
            $table->string('teamname')-> notNull()->unique();
            $table->string('teammate')-> notNull();
            $table->string('captain',20)-> notNull()->unique();
            $table->string('wait_rec')->default('a:0:{}');
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
        Schema::dropIfExists('team');
    }
};
