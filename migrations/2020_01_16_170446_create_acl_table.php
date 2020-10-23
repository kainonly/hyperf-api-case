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
            $table->bigIncrements('id')
                ->comment('primary key');
            $table->string('key', 50)
                ->unique()
                ->comment('access control list key');
            $table->json('name')
                ->comment('access control list name');
            $table->longText('write')
                ->nullable()
                ->comment('write list');
            $table->longText('read')
                ->nullable()
                ->comment('read list');
            $table->boolean('status')
                ->default(1)
                ->unsigned()
                ->comment('status');
            $table->bigIncrements('create_time')
                ->default(0)
                ->unsigned()
                ->comment('create time');
            $table->bigIncrements('update_time')
                ->default(0)
                ->unsigned()
                ->comment('update time');
        });
        $this->comment('acl', 'Access Control List Table');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acl');
    }
}
