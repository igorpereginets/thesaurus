<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('word_groups', function (Blueprint $table) {
            $table->foreignId('word_id')->references('id')->on('words');
            $table->foreignId('group_id')->references('id')->on('groups');
            $table->primary(['group_id', 'word_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('word_groups');
        Schema::dropIfExists('groups');
    }
}
