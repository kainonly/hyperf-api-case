<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_resource', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');

            $table->string('role_key', 30)
                ->comment('role key');

            $table->string('resource_key', 30)
                ->comment('resource manage key');

            $table->foreign('role_key')
                ->references('key')
                ->on('role_basic')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('resource_key')
                ->references('key')
                ->on('resource')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(['role_key', 'resource_key']);
        });

        DB::statement("ALTER TABLE `v_role_resource` comment 'Resource Manage For Associated Role Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_resource');
    }
}
