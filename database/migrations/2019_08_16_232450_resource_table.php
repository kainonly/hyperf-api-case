<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');

            $table->string('key', 30)
                ->unique()
                ->comment('resource manage key');

            $table->string('parent', 30)
                ->default('origin')
                ->comment('resource key parent');

            $table->json('name')
                ->comment('resource name');

            $table->boolean('nav')
                ->default(0)
                ->unsigned()
                ->comment('is nav');

            $table->boolean('router')
                ->default(0)
                ->unsigned()
                ->comment('is router');

            $table->boolean('policy')
                ->default(0)
                ->unsigned()
                ->comment('is policy node');

            $table->string('icon', 50)
                ->nullable()
                ->comment('icon font');

            $table->tinyInteger('sort')
                ->default(0)
                ->unsigned()
                ->comment('sort');

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

        DB::statement("ALTER TABLE `v_resource` comment 'Resource Manager Table'");
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
