<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefProjectsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_projects_groups', function (Blueprint $table) {
            /**
             * Columns
             */
            $table->integer('project_id')->unsigned();
            $table->integer('group_id')->unsigned();

            /**
             * Foreign keys
             */
            $table->foreign('project_id')
                ->on('projects')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('group_id')
                ->on('groups')
                ->references('id')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_projects_groups');
    }
}
