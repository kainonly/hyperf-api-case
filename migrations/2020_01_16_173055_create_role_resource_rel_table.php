<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateRoleResourceRelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_resource_rel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role_key', 200)
                ->comment('权限组键关联');
            $table->string('resource_key', 200)
                ->comment('资源键关联');
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
        $this->comment('role_resource_rel', '权限组资源关联表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_resource_rel');
    }
}
