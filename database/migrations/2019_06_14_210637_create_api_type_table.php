<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_type', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->json('name')->comment('类型名称');
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
        Schema::dropIfExists('api_type');
    }
}
