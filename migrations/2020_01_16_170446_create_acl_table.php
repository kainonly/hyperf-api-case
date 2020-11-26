<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateAclTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('acl', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 200)
                ->unique()
                ->comment('访问控制键');
            $table->json('name')
                ->comment('访问控制键名称');
            $table->longText('write')
                ->nullable()
                ->comment('写入控制项');
            $table->longText('read')
                ->nullable()
                ->comment('读取控制项');
            $table->boolean('status')
                ->default(1)
                ->unsigned();
            $table->unsignedBigInteger('create_time')
                ->default(0);
            $table->unsignedBigInteger('update_time')
                ->default(0);
        });
        $this->comment('acl', '访问控制表');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acl');
    }
}
