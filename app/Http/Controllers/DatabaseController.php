<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Repositories\DatabaseRepository;
use Illuminate\Http\Request;

class DatabaseController extends BaseController
{

	public function __construct(DatabaseRepository $dbRepo)
	{
		$this->dbRepo = $dbRepo;
	}
   	

   	public function createDBTables()
   	{
   		try {

   			$this->dbRepo->createTagDetailsTable();
	   		$this->dbRepo->createQuestionDetailsTable();
	   		return response()->json([
	   			"status" => "success",
	   			"success_type" => "TABLES_CREATED",
	   			"success_text" => "Tables created successfully."
	   		]);

   		} catch(\Exception $e) {

   			return response()->json([
	   			"status" => "error",
	   			"error_type" => "FAILED_TO_CREATE_TABLES",
	   			"error_text" => "Failed to create tables.",
	   			'error_log_text' => $e->getMessage(), 
	   		]);

   		}
   	}


}
