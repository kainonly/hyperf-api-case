<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateRoleResourceTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_resource', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');
            $table->string('role_key', 50)
                ->comment('role key');
            $table->string('resource_key', 50)
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
        $this->comment('role_resource', 'Resource Manage For Associated Role Table');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_resource');
    }
}
