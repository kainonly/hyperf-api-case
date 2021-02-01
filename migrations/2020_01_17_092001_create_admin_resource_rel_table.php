<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateAdminResourceRelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_resource_rel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_id')
                ->comment('管理员关联');
            $table->string('resource_key', 200)
                ->comment('资源键关联');
            $table->foreign('admin_id')
                ->references('id')
                ->on('admin')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('resource_key')
                ->references('key')
                ->on('resource')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unique(['admin_id', 'resource_key']);
        });
        $this->comment('admin_resource_rel', '管理员个人权限关联表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_resource_rel');
    }
}
