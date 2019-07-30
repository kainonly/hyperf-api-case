<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('username', 20)->unique()->comment('用户名');
            $table->text('password')->comment('口令');
            $table->string('call', 10)->nullable()->comment('称呼');
            $table->string('phone', 11)->nullable()->comment('手机号');
            $table->string('email', 50)->nullable()->comment('电子邮件');
            $table->string('avatar', 100)->nullable()->comment('头像');
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
        Schema::dropIfExists('admin');
    }
}
