<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');

            $table->string('key', 30)
                ->unique()
                ->comment('access control list key');

            $table->json('name')
                ->comment('access control list name');

            $table->text('write')
                ->nullable()
                ->comment('write list');

            $table->text('read')
                ->nullable()
                ->comment('read list');

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

        DB::statement("ALTER TABLE `v_acl` comment 'Access Control List Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acl');
    }
}
