<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tag Graph Detials</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script type="text/javascript" src="http://jtblin.github.io/angular-chart.js/node_modules/chart.js/dist/Chart.min.js"></script>
<script type="text/javascript" src="http://jtblin.github.io/angular-chart.js/angular-chart.js"></script>
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

	.fa-backward {
		font-size: 25px;
	    position: fixed;
	    top: 0px;
	    left: 0px;
	    cursor: pointer;
	    background: #eeeeee;
	}

  </style>
</head>
<body ng-app="GraphDetailsApp" ng-controller="GraphDetailsController">
<i class="fa fa-backward" title="Click to go back" ng-click="back()"></i>
<div class="page-header center">
  <h1>Tag Graph Detials</h1>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-8 text-center col-centered" style="background-color: rgba(0, 0, 0, 0.06);">
    	<label>All Tags</label>
    	<canvas id="all_tag" class="chart chart-pie"
		  chart-data="all_tag_data" chart-labels="all_tag_label" chart-options="options">
		</canvas> 

    </div>
   </div>
   <br><br><br>
   <div class="row">
   		<div class="text-center">
   			<label class="text-center">Individual Tag Details</label>
   		</div>

   		<br>
   		@foreach($tags as $tag)
   			<div class="col-sm-4 text-center" style="padding: 10px;">
   				<label>{{$tag['tag_name']}}</label>
   				<canvas id="tag_{{$tag['id']}}" class="chart chart-pie"
				  chart-data="tag_{{$tag['id']}}_data" chart-labels="tag_{{$tag['id']}}_label" chart-options="options">
				</canvas>
   			</div>
    	@endforeach
   		
   </div>


</div>
</body>
<script type="text/javascript">
	var app = angular.module('GraphDetailsApp', ['chart.js'], function($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    }).controller('GraphDetailsController', function($scope, $http, $window) {
	   

    	$scope.all_tag_label = [
    		@foreach($tags as $tag)
    			'{{$tag['tag_name']}}, No of Question',
    		@endforeach
    	];
  		$scope.all_tag_data = [
  			@foreach($tags as $tag)
    			'{{$tag['number_of_questions']}}',
    		@endforeach
  		];


  		@foreach($tags as $tag)
  			$scope.tag_{{$tag['id']}}_label = [
  				'Total questions', 'Total questions with answers'
  			];
  			$scope.tag_{{$tag['id']}}_data = [
  				'{{$tag['number_of_questions']}}', '{{$tag['number_of_questions_with_answers']}}'
  			];
		@endforeach


		$scope.back = function()
		{
			$window.location.href = "{{url('/')}}";
		}
	});
</script>
</html>
