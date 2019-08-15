<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->increments('id')
                ->comment('主键');

            $table->json('name')
                ->comment('权限名称');

            $table->text('router')
                ->comment('路由授权');

            $table->text('api')
                ->comment('接口授权');

            $table->text('note')
                ->nullable()
                ->comment('备注');

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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
    }
}
