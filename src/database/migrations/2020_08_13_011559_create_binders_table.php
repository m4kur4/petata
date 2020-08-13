<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('create_user_id');
            $table->string('name');
            $table->timestamps();

            // 参照制約 - ユーザー
            $table->foreign('create_user_id')
                ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('binders');
    }
}
