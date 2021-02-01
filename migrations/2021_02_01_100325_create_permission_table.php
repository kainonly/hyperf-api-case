<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permission', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')
                ->comment('特殊授权名称');
            $table->text('key')
                ->comment('特殊授权键');
            $table->text('note')
                ->nullable()
                ->comment('备注');
            $table->boolean('status')
                ->default(1)
                ->unsigned();
            $table->unsignedBigInteger('create_time')
                ->default(0);
            $table->unsignedBigInteger('update_time')
                ->default(0);
        });
        $this->comment('permission', '特殊授权表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission');
    }
}
