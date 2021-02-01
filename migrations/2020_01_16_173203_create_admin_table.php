<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 50)
                ->unique()
                ->comment('用户名');
            $table->text('password')
                ->comment('用户密码');
            $table->string('email', 200)
                ->nullable()
                ->comment('电子邮件');
            $table->longText('permission')
                ->nullable()
                ->comment('特殊授权');
            $table->string('phone', 20)
                ->nullable()
                ->comment('联系电话');
            $table->string('call', 20)
                ->nullable()
                ->comment('称呼');
            $table->text('avatar')
                ->nullable()
                ->comment('头像');
            $table->boolean('status')
                ->default(1)
                ->unsigned();
            $table->unsignedBigInteger('create_time')
                ->default(0);
            $table->unsignedBigInteger('update_time')
                ->default(0);
        });
        $this->comment('admin', '管理员表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
}
