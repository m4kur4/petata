<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('binder_id');
            $table->unsignedBigInteger('upload_user_id');
            $table->string('path');
            $table->boolean('visible')->comment('表示可能フラグ');
            $table->timestamps();

            // 参照制約 - ユーザー
            $table->foreign('upload_user_id')
                ->references('id')->on('users');

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
        Schema::dropIfExists('images');
    }
}
