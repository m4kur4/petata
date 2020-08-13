<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinderAuthoritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binder_authorities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('binder_id');
            $table->tinyInteger('level')->comments('バインダー操作権限レベル');
            $table->timestamps();

            // 参照制約 - ユーザー(CASCADE DELETE)
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

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
        Schema::dropIfExists('binder_authorities');
    }
}
