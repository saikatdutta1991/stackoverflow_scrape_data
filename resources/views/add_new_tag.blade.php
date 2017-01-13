<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add New Tag</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
  <style type="text/css">
  	.col-centered{
	    float: none;
	    margin: 0 auto;
	}
	.panel-links {
		cursor: pointer;
    	border: 1px solid #eeeeee;
	}

	.center {
		text-align: center;
	}
	.add-tag-group {
		width: 100%;
	}
	.add-tag-group:last-child {
		cursor: pointer;
	}

	#backbutton {
		font-size: 25px;
	    position: fixed;
	    top: 0px;
	    left: 0px;
	    cursor: pointer;
	    background: #eeeeee;
	}

  </style>
</head>
<body ng-app="AddNewTagApp" ng-controller="AddNewTagController">
<i class="fa fa-backward" id = "backbutton" title="Click to go back" ng-click="back()"></i>
<div class="page-header center">
  <h1>Add New Tag</h1>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-6 text-center col-centered">
    	<div class="alert alert-success alert-div" style="display: none;"></div>

    	<form class="form-inline">
    		<div class="input-group add-tag-group">
			  <span class="input-group-addon"><i class="fa fa-tag"></i></span>
			  <input type="text" class="form-control" placeholder="Enter new tag" ng-model="newTag">
			  <span class="input-group-addon" ng-click="addTag()"><i class="fa fa-plus"></i></span>
			</div>
		</form>


		<br><br>
		<div class="well well-sm">Tag Details</div>
		<div class="table-responsive">
		<table class="table table-bordered">
	    <thead>
	      <tr>
	        <th>Tag Name</th>
	        <th>Questions</th>
	        <th>Questions with Answers</th>
	      </tr>
	    </thead>
	    <tbody>
	      <tr>
	        <td>[[tagDetails.tag]]</td>
	        <td>[[tagDetails.no_of_questions]]</td>
	        <td>[[tagDetails.no_of_questions_with_answers]]</td>
	      </tr>
	    </tbody>
	  </table>
	  </div>

	  <br><br>
		<div class="well well-sm">Question Details</div>
		<div class="table-responsive">
		<table class="table table-bordered table-responsive">
	    <thead>
	      <tr>
	        <th>Question ID</th>
	        <th>Question</th>
	        <th>Votes</th>
	        <th>Answers</th>
	        <th>Views</th>
	      </tr>
	    </thead>
	    <tbody>
	      <tr ng-repeat="questionDetail in tagDetails.question_details">
	        <td>[[questionDetail.question_id]]</td>
	        <td>[[questionDetail.question]]</td>
	        <td>[[questionDetail.votes]]</td>
	        <td>[[questionDetail.answers]]</td>
	        <td>[[questionDetail.views]]</td>
	      </tr>
	    </tbody>
	  </table>
	  </div>

    </div>
</div>
</body>
<script type="text/javascript">
	
	var app = angular.module('AddNewTagApp', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    }); 

	app.controller('AddNewTagController', function($scope, $http, $window) {
	    
	    $scope.csrf_token = "{{csrf_token()}}";
	    $scope.newTag = "";
	    $scope.tagDetails = null;
		$scope.back = function()
		{
			$window.location.href = "{{url('/')}}";
		}


		$scope.addTag = function()
		{
			$scope.hideStatusDiv();
			$scope.showLoaderDiv('Fetching...');
			$scope.tagDetails = null;
			$http({
                method : "POST",
                url : "{{url('tags/add')}}",
                data:{_token:$scope.csrf_token, tag:$scope.newTag}
            }).then(function success(response) {
            	if(response.data.status == "success") {
            		$scope.tagDetails = response.data.data;
            		console.log($scope.tagDetails);
            		$scope.showSuccessDiv("Data fetched and saved.");
            	} else if(response.data.status == "error") {
            		$scope.showErrorDiv(response.data.error_text);
            	}

            }, function error(response) {$scope.hideStatusDiv()});
		}

		
		$scope.showErrorDiv = function (text)
		{
			$(".alert-div").removeClass('alert-success').removeClass('alert-info').addClass('alert-danger').text(text).show();
			return true;
		}

		$scope.hideStatusDiv = function ()
		{
			$(".alert-div").hide();
			return false;
		}


		$scope.showSuccessDiv = function (text)
		{
			$(".alert-div").removeClass('alert-danger').removeClass('alert-info').addClass('alert-success').text(text).show();
			return true;
		}


		$scope.showLoaderDiv = function (text)
		{
			$(".alert-div").removeClass('alert-danger').removeClass('alert-success').addClass('alert-info').text(text).show();
			return true;
		}


	});


	function showErrorDiv(text)
	{
		$(".alert-div").removeClass('alert-success').removeClass('alert-info').addClass('alert-danger').text(text).show();
	}

	
</script>
</html>
