<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

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
        $this->comment('admin_role', 'Role Policy For Associated Admin Table');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_role');
    }
}
