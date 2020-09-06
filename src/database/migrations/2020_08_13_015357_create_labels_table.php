<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('binder_id');
            $table->string('name');
            $table->integer('sort');
            $table->text('description');
            $table->timestamps();

            // 参照制約 - バインダー(CASCADE DELETE)
            $table->foreign('binder_id')
                ->references('id')->on('binders')
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
        Schema::dropIfExists('labels');
    }
}
