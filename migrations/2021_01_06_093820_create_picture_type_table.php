<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreatePictureTypeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('picture_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)
                ->comment('类型名称');
            $table->unsignedBigInteger('sort')
                ->default(0)
                ->comment('排序');
            $table->unsignedBigInteger('create_time')
                ->default(0);
            $table->unsignedBigInteger('update_time')
                ->default(0);
        });
        $this->comment('picture_type', '图片素材分类表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('picture_type');
    }
}
