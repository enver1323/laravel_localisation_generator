<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefGroupsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_groups_translations', function (Blueprint $table) {
            /**
             * Columns
             */
            $table->integer('group_id')->unsigned();
            $table->integer('translation_id')->unsigned();

            /**
             * Foreign keys
             */
            $table->foreign('group_id')
                ->on('groups')
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
        Schema::dropIfExists('ref_groups_translations');
    }
}
