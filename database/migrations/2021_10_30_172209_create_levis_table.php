<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_levis', function (Blueprint $table) {
            $table->increments('lId');
            $table->string('lName');
            $table->integer('typeId')->unsigned();
            $table->integer('brandId')->unsigned();
            $table->integer('lPrice');
            $table->text('lDescription')->nullable();
            $table->text('lImage')->nullable();
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
        Schema::dropIfExists('tb_levis');
    }
}
