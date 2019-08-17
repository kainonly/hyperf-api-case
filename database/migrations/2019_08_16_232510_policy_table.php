<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PolicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policy', function (Blueprint $table) {
            $table->increments('id')
                ->comment('primary key');

            $table->string('resource_key', 30)
                ->comment('resource manage key');

            $table->string('acl_key', 30)
                ->comment('access control key');

            $table->enum('policy', ['r', 'rw'])
                ->comment('policy');

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

        DB::statement("ALTER TABLE `v_policy` comment 'Access Control Policy For Associated Resource Key Table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policy');
    }
}
