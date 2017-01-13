<?php

namespace App\Repositories;

use Illuminate\Database\Schema\Blueprint;
use DB;
use Schema;


class DatabaseRepository
{


	public function createTagDetailsTable()
	{
		Schema::dropIfExists('tag_details');
  		Schema::create('tag_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tag_name', 255)->unique();
            $table->string('number_of_questions', 11);
            $table->string('number_of_questions_with_answers', 11);
            $table->timestamps();
            $table->softDeletes();
        });
	}


	public function createQuestionDetailsTable()
	{
		Schema::dropIfExists('question_details');
  		Schema::create('question_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tag_details_id');
            $table->string('stackoverflow_question_id', 255);
            $table->string('question', 500);
            $table->string('votes', 11);
            $table->string('answers', 11);
            $table->string('views', 11);
            $table->timestamps();
            $table->softDeletes();
        });
	}


}