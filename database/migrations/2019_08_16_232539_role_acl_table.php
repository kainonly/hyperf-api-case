<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleAclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_acl', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');

            $table->string('role_key', 30)
                ->comment('role key');

            $table->string('acl_key', 30)
                ->comment('access control key');

            $table->enum('policy', ['r', 'rw'])
                ->comment('policy');

            $table->foreign('role_key')
                ->references('key')
                ->on('role_basic')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('acl_key')
                ->references('key')
                ->on('acl')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(['role_key', 'acl_key']);
        });

        DB::statement("ALTER TABLE `v_role_acl` comment 'Access Control Policy For Associated Role Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_acl');
    }
}
