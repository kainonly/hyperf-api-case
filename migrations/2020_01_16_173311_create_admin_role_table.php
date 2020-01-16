<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;
use Hyperf\DbConnection\Db;

class CreateAdminRoleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_role', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');
            $table->integer('admin_id')
                ->unsigned()
                ->comment('admin id');
            $table->string('role_key', 50)
                ->comment('role key');
            $table->foreign('admin_id')
                ->references('id')
                ->on('admin_basic')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('role_key')
                ->references('key')
                ->on('role_basic')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['admin_id', 'role_key']);
        });

        Db::statement(/** @lang text */ "ALTER TABLE `v_admin_role` comment 'Role Policy For Associated Admin Table'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_role');
    }
}
