<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateAdminRoleRelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_role_rel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_id')
                ->comment('管理员关联');
            $table->string('role_key', 200)
                ->comment('权限组键关联');
            $table->foreign('admin_id')
                ->references('id')
                ->on('admin')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('role_key')
                ->references('key')
                ->on('role')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        $this->comment('admin_role_rel', '管理员权限组关联表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_role_rel');
    }
}
