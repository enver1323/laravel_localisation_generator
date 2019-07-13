<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefProjectsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_projects_translations', function (Blueprint $table) {
            /**
             * Columns
             */
            $table->integer('project_id')->unsigned();
            $table->integer('translation_id')->unsigned();

            /**
             * Foreign keys
             */
            $table->foreign('project_id')
                ->on('projects')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('translation_id')
                ->on('translations')
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
        Schema::dropIfExists('ref_project_translations');
    }
}
