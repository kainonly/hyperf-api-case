<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateResourceTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resource', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');
            $table->string('key', 50)
                ->unique()
                ->comment('resource manage key');
            $table->string('parent', 50)
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
        $this->comment('resource', 'Resource Manager Table');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource');
    }
}
