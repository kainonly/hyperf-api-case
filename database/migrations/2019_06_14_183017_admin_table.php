<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id')
                ->comment('主键');

            $table->integer('role_id')
                ->unsigned()
                ->comment('权限ID');

            $table->string('username', 30)
                ->unique()
                ->comment('用户名');

            $table->text('password')
                ->comment('口令');

            $table->boolean('status')
                ->default(1)
                ->unsigned()
                ->comment('状态');

            $table->integer('create_time')
                ->default(0)
                ->unsigned()
                ->comment('创建时间');

            $table->integer('update_time')
                ->default(0)
                ->unsigned()
                ->comment('更新时间');

            $table->foreign('role_id')
                ->references('id')
                ->on('role');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
