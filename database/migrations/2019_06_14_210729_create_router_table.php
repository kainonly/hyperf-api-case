<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('router', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('parent')->default(0)->comment('父级关联');
            $table->json('name')->comment('路由名称');
            $table->boolean('nav')->unsigned()->default(0)->comment('是否为路由');
            $table->string('icon', 30)->nullable()->comment('字体图标');
            $table->string('routerlink', 90)->nullable()->comment('路由地址');
            $table->unsignedTinyInteger('sort')->default(0)->comment('排序');
            $table->boolean('status')->unsigned()->default(1)->comment('状态');
            $table->unsignedInteger('create_time')->default(0)->comment('创建时间');
            $table->unsignedInteger('update_time')->default(0)->comment('更新时间');
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
