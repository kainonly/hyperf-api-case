<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateGalleryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_id')
                ->comment('分类外键');
            $table->string('name', 50)
                ->comment('元素名称');
            $table->text('url')
                ->comment('元素路径');
            $table->boolean('status')
                ->default(1)
                ->unsigned();
            $table->unsignedBigInteger('create_time')
                ->default(0);
            $table->unsignedBigInteger('update_time')
                ->default(0);
            $table->foreign('type_id')
                ->references('id')
                ->on('gallery_type')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        $this->comment('gallery', '图库表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
}
