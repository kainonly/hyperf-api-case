<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api', function (Blueprint $table) {
            $table->increments('id')
                ->comment('主键');
            $table->string('mark', 20)
                ->comment('标记');
            $table->string('vhost', 50)
                ->unique()
                ->comment('虚拟域');
            $table->text('write')
                ->nullable()
                ->comment('可写列表');
            $table->text('read')
                ->nullable()
                ->comment('可读列表');
            $table->boolean('delete')
                ->default(0)
                ->unsigned()
                ->comment('可删除');
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
        Schema::dropIfExists('resource');
    }
}
