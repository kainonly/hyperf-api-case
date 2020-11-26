<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateResourceTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resource', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 200)
                ->unique()
                ->comment('资源控制键');
            $table->string('parent', 200)
                ->default('origin')
                ->comment('资源键父节点');
            $table->json('name')
                ->comment('资源控制名称');
            $table->boolean('nav')
                ->default(0)
                ->unsigned()
                ->comment('是否为导航（中后台菜单显示）');
            $table->boolean('router')
                ->default(0)
                ->unsigned()
                ->comment('是否为路由（映射前端路由地址）');
            $table->boolean('policy')
                ->default(0)
                ->unsigned()
                ->comment('是否为策略节点（可关联访问控制）');
            $table->string('icon', 200)
                ->nullable()
                ->comment('字体图标');
            $table->unsignedTinyInteger('sort')
                ->default(0)
                ->comment('排序');
            $table->boolean('status')
                ->default(1)
                ->unsigned();
            $table->unsignedBigInteger('create_time')
                ->default(0);
            $table->unsignedBigInteger('update_time')
                ->default(0);
        });
        $this->comment('resource', '资源控制表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource');
    }
}
