<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tag Detials</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
<body>
<i class="fa fa-backward" title="Click to go back" onClick="window.location.href='{{url('/')}}'"></i>
<div class="page-header center">
  <h1>All Tag Detials</h1>
</div>
<div class="container">
  <div class="row">
    <div class="col-sm-12 text-center col-centered">
 
    @foreach($tags as $tag)
    	<div class="panel-group">
		  <div class="panel panel-default">
		    <div class="panel-heading">
		      <h4 class="panel-title">
		        <a data-toggle="collapse" href="#col_{{$tag['id']}}">Tag : {{$tag['tag_name']}}</a>
		      </h4>
		    </div>
		    <div id="col_{{$tag['id']}}" class="panel-collapse collapse">
		    	<div class="table-responsive">
		      <table class="table table-bordered">
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
			    	@foreach($tag['question_details'] as $question)
			    	<tr>
			      	<td>{{$question['stackoverflow_question_id']}}</td>
			        <td>{{$question['question']}}</td>
			        <td>{{$question['votes']}}</td>
			        <td>{{$question['answers']}}</td>
			        <td>{{$question['views']}}</td>
			        </tr>
			        @endforeach
			    </tbody>
			  </table>
			  </div>
		    </div>
		  </div>
		</div>
	@endforeach

    </div>
   </div>

</div>
</body>
<script type="text/javascript">
</script>
</html>
