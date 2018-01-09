<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToDoListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_do_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title', 150);
            $table->string('description', 300)->nullable();
            $table->integer('priority');
            $table->datetime('due_date')->nullable();
            $table->boolean('is_completed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('to_do_list');
    }
}
