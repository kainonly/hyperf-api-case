<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminBasicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

        DB::statement("ALTER TABLE `v_admin_basic` comment 'Admin Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_basic');
    }
}
