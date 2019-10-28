<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_role', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');

            $table->integer('admin_id')
                ->unsigned()
                ->comment('admin id');

            $table->string('role_key', 30)
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

        DB::statement("ALTER TABLE `v_admin_role` comment 'Role Policy For Associated Admin Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_role');
    }
}
