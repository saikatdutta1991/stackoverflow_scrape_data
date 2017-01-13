<?php

namespace App\Repositories;

use PHPHtmlParser\Dom;
use App\Models\TagDetail;
use App\Models\QuestionDetail;
use stdClass;
use DB;


class TagRepository 
{

	protected $dom = null;
	protected $tag = "";
	protected $noOfQuestions = 0;
	protected $noOfQuestionsWithAnswers = 0;
	protected $questionDetails = [];
	protected $parseSuccessFull = false;


	public function __construct(TagDetail $tagDetail, QuestionDetail $questionDetail)
	{
		$this->dom = new Dom;
		$this->tagDetail = $tagDetail;
		$this->questionDetail = $questionDetail;
	}

	

	public function setTag($tag)
	{
		$this->tag = $tag;
		return $this;
	}

	public function getTag()
	{
		return $this->tag; 
	}




	protected function getURL()
	{
		return $this->url = "http://stackoverflow.com/questions/tagged/".$this->tag."?pagesize=50";
	}



	protected function getTagSummaries()
	{
		return $this->dom->find('.question-summary');
	}



	protected function decodeValue($value)
	{
		if(!is_string($value)) return 0;
		$map = array("k" => 1000,"m" => 1000000,"b" => 1000000000);
		list($value,$suffix) = sscanf($value, "%f%s");
		return isset($map[$suffix]) ? (string)($value*$map[$suffix]) : $value;
	}


	public function getNumberOfQuestions()
	{
		return $this->noOfQuestions;
	}


	public function getNumberOfQuestionsWithAnswers()
	{
		return $this->noOfQuestionsWithAnswers;
	}


	public function getQuestionDetails()
	{
		return $this->questionDetails;
	}


	protected function getQuesitonID($summary)
	{
		return explode("-", $summary->getAttribute('id'))[2];
	}

	protected function getQuestion($summary)
	{
		return $summary->find('.summary h3 a')->text;
	}

	protected function getVotes($summary)
	{
		return $summary->find(".statscontainer .stats .votes .vote-count-post strong")->text;
	}

	protected function getAnswers($summary)
	{
		return $summary->find(".statscontainer .stats .status strong")->text;
	}


	protected function getViews($summary) 
	{
		return $viewString = explode(" ", trim($summary->find(".statscontainer .views")->text))[0];
		//return $this->decodeValue($viewString);
	}


	public function parseTagDetails()
	{
		$this->parseSuccessFull = false;
		$this->dom->loadFromUrl($this->getURL());
		$questionSummaries = $this->getTagSummaries();
		
		foreach($questionSummaries as $summary) {
			
			$this->noOfQuestions++;
			
			$question = new stdClass;
			
			$question->question_id = $this->getQuesitonID($summary);
			$question->question = $this->getQuestion($summary);
			$question->votes = $this->getVotes($summary);
			$question->answers = $this->getAnswers($summary);
			$question->views = $this->getViews($summary);

			if($question->answers > 0) {
				$this->noOfQuestionsWithAnswers++;
			}

			$this->questionDetails[] = $question;
		}

		$this->parseSuccessFull = true;

	}


	protected function parsed()
	{
		return $this->parseSuccessFull;
	}



	public function isTagExistsByName($tag)
	{
		return $this->tagDetail->where('tag_name', strtolower($tag))->exists();
	}


	public function saveTagDetails()
	{
		if(!$this->parsed()) {
			$this->saved = false;
			$this->save_log_text = "Parse not done";
			return;
		}

		DB::beginTransaction();

		try {

			$tag = new $this->tagDetail;
			$tag->tag_name = $this->getTag();
			$tag->number_of_questions = $this->getNumberOfQuestions();
			$tag->number_of_questions_with_answers = $this->getNumberOfQuestionsWithAnswers();
			$tag->save();

			$qDetails = $this->getQuestionDetails();

			foreach($qDetails as $question) {
				$questionDetail = new $this->questionDetail;
				$questionDetail->tag_details_id = $tag->id;
				$questionDetail->stackoverflow_question_id = $question->question_id;
				$questionDetail->question = $question->question;
				$questionDetail->votes = $question->votes;
				$questionDetail->answers = $question->answers;
				$questionDetail->views = $question->views;
				$questionDetail->save();
			}
			DB::commit();
			$this->saved = true;
			$this->save_log_text = "saved success fully";

		} catch(\Exception $e) {
			DB::rollBack();
			$this->saved = false;
			$this->save_log_text = $e->getMessage();
		}

	}	


	public function saveLog()
	{
		return isset($this->save_log_text) ? $this->save_log_text : "";
	}


	public function saved()
	{
		return isset($this->saved) ? $this->saved : false;
	}



	public function getAllTags()
	{
		return $this->tagDetail->with('questionDetails')->orderBy('created_at', 'desc')->get();
	}

}