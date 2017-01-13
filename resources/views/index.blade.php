<!DOCTYPE html>
<html lang="en">
<head>
  <title>Stack Overflow Tag Statistics</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
  	.col-centered{
	    float: none;
	    margin: 0 auto;
	}
	.panel-links {
		cursor: pointer;
    	border: 1px solid #eeeeee;
	}
  </style>
</head>
<body>

<div class="jumbotron text-center">
  <h1>Stack Overflow Tag Statistics</h1>
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-6 text-center col-centered">
    	<div class="alert alert-success alert-div" style="display: none;"></div>
    	<div class="panel panel-default">
		  <div class="panel-heading">Click Below Actions</div>
		  <div class="panel-body panel-links" id = "crate-tables">Create Tables(Set DB Config First)</div>
		  <div class="panel-body panel-links" id="add-new-tag">Add New Tag</div>
		  <div class="panel-body panel-links" id="see-tag-stats">See Tag Stats</div>
		  <div class="panel-body panel-links" id ="see-tag-graph-stats">See Tag Graph Stats</div>
		</div>
    </div>
</div>
</body>
<script type="text/javascript">
	
	var _token = "{{csrf_token()}}";

	$(document).ready(function(){


		$("#add-new-tag").on("click", function(){

			window.location.href = "{{url('tags/add')}}";

		});

		$("#see-tag-stats").on("click", function(){

			window.location.href = "{{url('tags/stats')}}";

		});

		$("#see-tag-graph-stats").on("click", function(){

			window.location.href = "{{url('tags/graph/stats')}}";

		});




		$("#crate-tables").on("click", function(){

			showLoaderDiv("wait ...");
			var URL = "{{url('create-database-tables')}}";
			$.post(URL, {_token:_token}, function(response){
				hideStatusDiv();
				if(response.status == 'success') {
					showSuccessDiv(response.success_text);
				} else if(response.status == 'error') {
					showErrorDiv(response.error_text);
					console.log(response.error_log_text);
				}

			});

		});

	});


	function showErrorDiv(text)
	{
		$(".alert-div").removeClass('alert-success').removeClass('alert-info').addClass('alert-danger').text(text).show();
	}

	function hideStatusDiv()
	{
		$(".alert-div").hide();
	}


	function showSuccessDiv(text)
	{
		$(".alert-div").removeClass('alert-danger').removeClass('alert-info').addClass('alert-success').text(text).show();
	}


	function showLoaderDiv(text)
	{
		$(".alert-div").removeClass('alert-danger').removeClass('alert-success').addClass('alert-info').text(text).show();
	}

</script>
</html>
