<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->index();
            $table->timestamps();
        });

        Schema::create('tag_task', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('tag_id')->unsigned();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['task_id','tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
