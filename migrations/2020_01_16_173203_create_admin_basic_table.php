<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateAdminBasicTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_basic', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');
            $table->string('username', 30)
                ->unique()
                ->comment('username');
            $table->text('password')
                ->comment('password');
            $table->string('email', 100)
                ->nullable()
                ->comment('email');
            $table->string('phone', 20)
                ->nullable()
                ->comment('phone');
            $table->string('call', 30)
                ->nullable()
                ->comment('call');
            $table->text('avatar')
                ->nullable()
                ->comment('avatar');
            $table->boolean('status')
                ->default(1)
                ->unsigned()
                ->comment('status');
            $table->integer('create_time')
                ->default(0)
                ->unsigned()
                ->comment('create time');
            $table->integer('update_time')
                ->default(0)
                ->unsigned()
                ->comment('update time');
        });
        $this->comment('admin_basic', 'Admin Table');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_basic');
    }
}
