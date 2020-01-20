<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Extra\Common\Migration;

class CreateRoleBasicTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_basic', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');
            $table->string('key', 50)
                ->unique()
                ->comment('role key');
            $table->json('name')
                ->comment('role name');
            $table->text('note')
                ->nullable()
                ->comment('mark');
            $table->boolean('status')
                ->default(1)
                ->unsigned()
                ->comment('status');
            $table->integer('create_time')
                ->default(0)
                ->unsigned()
                ->comment('create time');
            $table->integer('update_time')
                ->default(0)
                ->unsigned()
                ->comment('update time');
        });
        $this->comment('role_basic', 'Role Table');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_basic');
    }
}
