<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('type')->comment('类型关联');
            $table->foreign('type')
                ->references('id')
                ->on('api_type')
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');
            $table->json('name')->comment('接口名称');
            $table->string('api', 90)->unique()->comment('接口地址');
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
        Schema::dropIfExists('api');
    }
}
