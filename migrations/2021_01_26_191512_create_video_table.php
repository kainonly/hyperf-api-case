<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('video', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_id')
                ->default(0)
                ->comment('分类关联(0为未分类)');
            $table->text('name')
                ->comment('元素名称');
            $table->text('url')
                ->comment('元素路径');
            $table->unsignedBigInteger('create_time')
                ->default(0);
            $table->unsignedBigInteger('update_time')
                ->default(0);
        });
        $this->comment('video', '视频素材表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video');
    }
}
