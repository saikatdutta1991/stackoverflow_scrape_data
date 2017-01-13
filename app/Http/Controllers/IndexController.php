<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class IndexController extends BaseController
{

	public function __construct(TagRepository $tagRepo)
	{
		$this->tagRepo = $tagRepo;
	}
   	

   	public function index()
   	{
   		return view('index');
   	}


   	public function showAddNewTagPage()
   	{
   		return view('add_new_tag');
   	}



   	public function addTagDetails(Request $request)
   	{
         if($request->tag == "") {
            return response()->json([
               "status" => "error",
               "error_type" => "TAG_REQUIRED",
               "error_text" => "Tag required"
            ]);
         }

         if($this->tagRepo->isTagExistsByName($request->tag)) {
            return response()->json([
               "status" => "error",
               "error_type" => "TAG_EXIST",
               "error_text" => "Tag Existed alredy"
            ]);
         }


   		$this->tagRepo->setTag($request->tag)->parseTagDetails();
         $this->tagRepo->saveTagDetails();

         if($this->tagRepo->saved()) {
            return response()->json([
               "status" => "success",
               "success_type" => "TAG_DETAILS_RETRIVED",
               "data" => [
                  "tag" => $request->tag,
                  "no_of_questions" => $this->tagRepo->getNumberOfQuestions(),
                  "no_of_questions_with_answers" => $this->tagRepo->getNumberOfQuestionsWithAnswers(),
                  "question_details" => $this->tagRepo->getQuestionDetails()
               ]
            ]);
         } else {
            return response()->json([
               "status" => "error",
               "error_type" => "SAVE_FAILED",
               "error_text" => "Failed to save tag details",
               "error_log" => $this->tagRepo->saveLog(),
            ]);
         }
   		
   		
   	}



      public function showTagStats()
      {
         return view('tag_details', [
            'tags' => $this->tagRepo->getAllTags()->toArray(),
         ]);
      }





      public function showTagGraphStats()
      {
         return view('tag_graph_details', [
            'tags' => $this->tagRepo->getAllTags()->toArray(),
         ]);
      }


}
