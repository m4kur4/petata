<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labelings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('image_id');
            $table->unsignedBigInteger('label_id');
            $table->timestamps();

            // 参照制約 - 画像(CASCADE DELETE)
            $table->foreign('image_id')
                ->references('id')->on('images')
                ->onDelete('cascade');

            // 参照制約 - ラベル(CASCADE DELETE)
            $table->foreign('label_id')
                ->references('id')->on('labels')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labelings');
    }
}
