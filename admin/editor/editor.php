<?php
include '../../includes/Authenticate.php';
include '../../classes/student.php';
//check whether the user is logged in or not,
if (!Authenticate::isLoggedIn())
{
	Authenticate::logout();
}
//protects the student section
if (Authenticate::getUserType() != "ADMIN")
{
	Authenticate::redirect();
}
//check whether user has already attempted the question if yes do nothing if no insert the user into scoreboard
//retrieve the question from the database

			$queryResult = Student::getQuestion($_GET['id']);


?>s

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CodeX: Student</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../../assets/css/main.css">
	<style type="text/css" media="screen">
		#editor {
			width: 1024px;
			height: 200px;
		}
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>
		/*var editor = ace.edit("editor");
		 editor.setTheme("ace/theme/monokai");
		 editor.getSession().setMode("ace/mode/c_cpp");*/
		$(document).ready(function(){
		    var responseTable = document.getElementById('compiler-response');
			$('#output').hide();
			$(responseTable).hide();
			$('#compilationError').hide();
			$('#compile').click(function (e) {
				$(this).attr("disabled", "disabled");
				$(responseTable).hide();
				$(responseTable).find('tbody tr').remove();
				e.preventDefault();
				$("#loading").show(); //show loading
				$("#status-compiling").show(); //show loading
				$('#compilationError').hide();
				var sourcecode = editor.getValue(),language = $('#language').val();
				$.ajax({
					url:"validatecode.php?qid=<?php if (isset($_GET['id'])) echo $_GET['id']; ?>",
					type : "POST",
					crossDomain: true,
					data:{ sourcecode: sourcecode,
						language: language
					},
					dataType: "json",
					success:function(result){
						if(result["compilationMessage"] === true) {
						var trHTML = '',testHTML = '',
                            testCaseTable = $('#test-case-details').find('tbody'),
							compilationMessage = result["compilationMessage"];
						var showExpctdOutput ='';
						$('#test-case-details').find('tbody tr').remove();
						$.each(result["compilationResult"], function (i, item) {
							trHTML += "<tr>";
							if (item.sample == true) {

								testHTML += '<tr id=test-case'+i+'>';
								trHTML += "<td>"+"TestCase " + (i + 1) + "(Sample)"+"</td>";
								showExpctdOutput = '<td><a href="#" class="text-primary" data-toggle="modal" data-target="#testcase-modal">Details</a></td>';
								item.expectedOutput = item.expectedOutput.replace(/(?:\r\n|\r|\n)/g, '<br />');
								testHTML += '<td>' + item.expectedOutput + '</td>';
								if (item.codeOutput!=null) {
									item.codeOutput = item.codeOutput.replace(/(?:\r\n|\r|\n)/g, '<br />');
									testHTML += '<td>' + item.codeOutput + '</td>';
								}
								testHTML += '</tr>';
							}
							if (item.sample == false) {
								trHTML += "<td>"+"TestCase " + (i + 1)+"</td>";
								showExpctdOutput = '<td>------</td>';

							}
							if (item.isPassed == "Passed")
								trHTML +=  '<td class="alert alert-success">' + item.isPassed+"</td>";
							if (item.isPassed == "Failed")
								trHTML +=  '</td><td class="alert alert-danger">' + item.isPassed+"</td>";
							trHTML += showExpctdOutput+'<td >' + item.time + '</td><td>' + item.memory + '</td><td>' + item.stderror + '</td><td>' + item.message + '</td></tr>';
						});
						///$('#compile-message').html(compileMessage);


                           $('#compilationError').removeClass('alert-danger').addClass('alert-success');
						   $(responseTable).append(trHTML);
						   $('#compilationError').find(".content").text("Compiled Sucessfully!");
						   $(testCaseTable).append(testHTML);
						   $(responseTable).show();
						   $('#output').show();
						   responseTable.scrollIntoView();
						   $('#testcase-modal').modal('show');
						   $('#compilationError').show().focus();
					   }
                       else{

                           $('#compilationError').removeClass('alert-success').addClass('alert-danger');
						   $('#compilationError').find(".content").html(result["compilationMessage"].replace(/(?:\r\n|\r|\n)/g, '<br />'));
						   $('#compilationError').show().focus();
                       }

						$("#compile").removeAttr("disabled");
						$("#loading").hide(); //hide loading here
						$("#status-compiling").hide();
                        $('#compilationError').show().focus();


					},
					complete: function(){
						$("#loading").hide(); //hide loading here
						$("#status-compiling").hide();
						$("#compile").removeAttr("disabled");
					},
					error: function (msg) {
						console.log(msg);
						$("#compile").removeAttr("disabled");
					}
				});
			});
		});
	</script>
</head>

<body>
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">CodeX</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<?php echo $_SESSION['username']; ?>
						<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Settings</a></li>
						<li><a href="#">Scoreboard</a></li>
						<li class="divider"></li>
						<li><a href="../../logout/">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

<div class="container-fluid">
	<div class="row">
		<section class="col-sm-3 col-md-2 sidebar"><ul class="nav nav-sidebar">
				<li><a href="/admin/">Home <span class="sr-only">(current)</span></a></li>
				<li ><a href="/admin/question/">Practice</a></li>
				<li ><a href="/admin/submissions/">MySubmissions</a></li>
				<li><a href="/admin/Challenges/">Contests</a></li>
			</ul>

		</section>
		<section class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<p class="lead"><strong>Question:</strong> <?php echo $queryResult[0]['questionName']; ?></p>


			<div role="tabpanel" class="col-md-12 col-sm-12">
				<a class="btn btn-default pull-right" target="_blank" href="../scoreboard/index.php<?php echo "?qid=".$_GET['id']."&type=".$_GET['type']; ?>">View Scoreboard</a>
				<a class="btn btn-success pull-right" href="#solve">Solve Question</a>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#problem" aria-controls="problem" role="tab" data-toggle="tab">Problem</a></li>
					<li role="presentation"><a href="#hint" aria-controls="hint" role="tab" data-toggle="tab">Hint</a></li>
					<li role="presentation"><a href="#solution" aria-controls="solution" role="tab" data-toggle="tab">Solution</a></li>
					<li role="presentation"><a href="#readings" aria-controls="readings" role="tab" data-toggle="tab">Readings</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="problem">
						<?php //nl2br
						echo html_entity_decode($queryResult[0]['questionStatement']);
						?>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="hint">
						<p>This section contains hints</p>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="solution">
						<p>This section contains solutions</p>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="readings">
						<p>This section contains readings</p>
					</div>
				</div>

			</div>

			<div class="col-md-12 col-sm-12 answer-block" id="solve">
				<h3 class="visible-sm-12 visible-xs-12 mobile-editor-head"><strong>Solve the problem below</strong></h3>

				<form class="answer-form">
					<div class="col-sm-5 pull-left"><label for="language">Select Language:</label>
					<select name="language" id="language" onchange="changeLanguage()">
						<option value="1">C</option>
					</select>
					<label id="status-compiling" style="display: none">Compiling....</label>
					<img src="compiling.gif" id="loading" height="30" width="30" style="display:none"/></div>
					<input type="submit" value="Compile and Check" class="btn btn-default btn-success pull-right" name="compile" id="compile">
					<br><br>
					<?php if(isset($_GET['type'])): ?>
						<?php	if ($_GET['type'] === 'cgf'): ?>
								<div>Character Count:
									<label id="count"></label>
								</div>
						<?php endif; ?>
					<?php endif; ?>
					<div id="editor"></div>

				</form>

			   <div id="compilationError" class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <p><strong>Compilation Message</strong></p>
				  <p class="content">

				  </p>
			   </div>

			   <div class="table-responsive">
			   <table class="table" id="compiler-response">
				   <caption><strong>Response from compiler</strong></caption>
					<thead>
					<tr>
					   <th>TestCase</th>
					   <th>Status</th>
					   <th>TestCase Details</th>
					   <th>Time</th>
					   <th>Memory</th>
					   <th>Standard Error</th>
					   <th>Message</th>
					</tr>
					</thead>
				   <tbody>
				   </tbody>
				</table>
			   </div>

               <div class="modal fade" id="testcase-modal">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           <h4 class="modal-title">Test Case Details</h4>
                        </div>
                        <div class="modal-body">
                           <table id="test-case-details" class="table table-bordered">
                              <thead>
							  	<tr>
									<th>Expected Output</th>
                              		<th>Code Output</th>
							  </thead>
                              <tbody>

                              </tbody>
                           </table>
                        </div>
                     </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
               </div><!-- /.modal -->


			</div>
		</section>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/ace-builds-master/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="/ace-builds-master/src-noconflict/ext-language_tools.js"></script>
<script type="text/javascript">
	ace.require("ace/ext/language_tools");
	var editor = ace.edit("editor");
	editor.setTheme("ace/theme/cobalt");
	editor.setShowPrintMargin(false);
	editor.setHighlightActiveLine(true);
	editor.setFontSize("18px");
	editor.getSession().setMode("ace/mode/c_cpp");
	editor.setFontSize = "40";
	editor.resize();
	editor.setOptions({
		enableBasicAutocompletion: true,
		enableSnippets: true,
		enableLiveAutocompletion: true
	});
	editor.setValue("#include<stdio.h>\n int main()\n{\n//Your Code Here\n\n\n return 0;\n}");
	/*function changeLanguage()
	{
		var ace_lang;
		var language = document.getElementById("language").value;
		switch(language)
		{
			case "1":
				ace_lang = 'c_cpp';
				editor.setValue(" #include<stdio.h>\n int main()\n{\n//Your Code Here\n\n\n return 0;\n} ");
				break;
			case "5":
				ace_lang = 'python';
				editor.setValue("");
				editor.setValue("#Your Solution Here\n ");
				break;
			case "3":
				ace_lang = 'java';
				editor.setValue("");
				editor.setValue("java");
				break;
			default:
				ace_lang ='c_cpp';
				editor.setValue("#include<stdio.h>\n int main()\n{\n//Your Code Here\n\n\n return 0;\n} ");
				break;
		}
		//alert(ace_lang);
		editor.getSession().setMode("ace/mode/"+ace_lang);

	}*/


</script>
</body>
</html>
