<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreatePolicyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('policy', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');
            $table->string('resource_key', 50)
                ->comment('resource manage key');
            $table->string('acl_key', 50)
                ->comment('access control key');
            $table->boolean('policy')
                ->default(0)
                ->unsigned()
                ->comment('policy,0:readonly,1:read & write');
            $table->foreign('resource_key')
                ->references('key')
                ->on('resource')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('acl_key')
                ->references('key')
                ->on('acl')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['resource_key', 'acl_key']);
        });

        Db::statement(/** @lang text */ "ALTER TABLE `v_policy` comment 'Access Control Policy For Associated Resource Key Table'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy');
    }
}
