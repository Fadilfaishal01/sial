<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_levis', function (Blueprint $table) {
            $table->foreign('typeId')->references('tId')
            ->on('tb_type')->onDelete('cascade')
            ->onUpdate('cascade');
        });

        Schema::table('tb_levis', function (Blueprint $table) {
            $table->foreign('brandId')->references('bId')
            ->on('tb_brand')->onDelete('cascade')
            ->onUpdate('cascade');
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
