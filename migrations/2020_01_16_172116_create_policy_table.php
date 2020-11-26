<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreatePolicyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('policy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('resource_key', 200)
                ->comment('资源键关联');
            $table->string('acl_key', 200)
                ->comment('访问键关联');
            $table->boolean('policy')
                ->default(0)
                ->unsigned()
                ->comment('读写策略（0为只读,1为读写）');
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
        $this->comment('policy', '策略设定表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy');
    }
}
