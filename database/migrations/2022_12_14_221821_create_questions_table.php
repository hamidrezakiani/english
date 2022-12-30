<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foreign_id');
           // $table->foreign('foreign_id')->references('id')->on('word_tests')->onDelete('cascade');
           // $table->foreign('foreign_id')->references('id')->on('readings')->onDelete('cascade');
            $table->enum('type',['WORD_TEST','READING_TEST']);
            $table->text('question');
            $table->text('translate')->nullable();
            $table->text('solve')->nullable();
            $table->string('orderIndex');
            $table->softDeletes();
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
        Schema::dropIfExists('questions');
    }
}
