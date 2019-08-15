<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RouterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('router', function (Blueprint $table) {
            $table->increments('id')
                ->comment('主键');

            $table->integer('parent')
                ->default(0)
                ->unsigned()
                ->comment('父级节点');

            $table->json('name')
                ->comment('路由名称');

            $table->boolean('nav')
                ->default(0)
                ->unsigned()
                ->comment('是否为导航');

            $table->string('icon', 50)
                ->nullable()
                ->comment('字体图标');

            $table->string('routerlink', 100)
                ->nullable()
                ->comment('路由地址');

            $table->tinyInteger('sort')
                ->default(0)
                ->unsigned()
                ->comment('排序');

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
        Schema::dropIfExists('router');
    }
}
