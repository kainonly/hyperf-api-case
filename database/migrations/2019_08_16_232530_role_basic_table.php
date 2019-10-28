<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleBasicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_basic', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');

            $table->string('key', 30)
                ->unique()
                ->comment('role key');

            $table->json('name')
                ->comment('role name');

            $table->text('note')
                ->nullable()
                ->comment('mark');

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

        DB::statement("ALTER TABLE `v_role_basic` comment 'Role Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_basic');
    }
}
