<div id="validationErrors">
	<?php include("php/create_new_user.php"); ?>
</div>
<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="js/jquery-2.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/log-in.css">

	<script type="text/javascript">
	//this is the code to switch tabs
	//it works by making one <div> visible while the other goes invisible
	$(document).ready(function() {
		var currentlyViewing = "";
  		$("a").click(function() {
			var targetDivID = $(this).attr("href");
			$(this).css("background-color", "white");
			$(this).css("color", "#006bb3");
			$(this).css("border", "none");
    		if (targetDivID == "#StudentForm") {
    			//switch the styling methods
    			$(targetDivID).css("display", "block");
    			$("#TeacherForm").css("display", "none");
    			//the rest of tis condition is just styling
    			$("#teacherButton").css("background-color", "#006bb3");
    			$("#teacherButton").css("color", "white");

    			$("#teacherButton").css("border-bottom", "2px solid black");
    			$("#teacherButton").css("border-left", "2px solid black");
   			} else {
   				//switch the styling methos=ds
      			$(targetDivID).css("display", "block");
    			$("#StudentForm").css("display", "none");
    			//the rest of this is just styling
    			$("#pupilButton").css("background-color", "#006bb3");
    			$("#pupilButton").css("color", "white");

    			$("#pupilButton").css("border-bottom", "2px solid black");
    			$("#pupilButton").css("border-right", "2px solid black");
    		}			
		})

	});
	</script>

</head>
<body>
<div class="logo">
	<h1><b>Digital</b> Homework Planner</h1>
</div>
<style>
	#formholder {
		height: 333px;
	}	
</style>
<div id="formholder">
	<ul class="nav nav-tab nav-justified">
		<li><a id="pupilButton" href="#StudentForm">Student</a></li>
		<li><a id="teacherButton" href="#TeacherForm">Teacher</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="StudentForm">
			<form method="post">
				<input type="text" name="name" id="name" placeholder="Name"></input>
				<input type="text" name="username" id="username" placeholder="Pupil ID"></input>
				<input type="password" name="password" id="password" placeholder="Password"></input>
				<input type="password" name="repeatedPassword" id="password" placeholder="Enter Password Again"></input>
				<input type="text" name="year" id="year" placeholder="Year"></input>
				<input type="text" name="email" id="email" placeholder="Email"></input>
				<input type="submit" class="submit" value="Sign Up!" name="pupilSubmit"></input>
			</form>
		</div>

		<div id="TeacherForm">
			<form method="post">
				<input type="text" name="name" id="name" placeholder="Name"></input>
				<input type="text" name="username" id="username" placeholder="Teacher ID"></input>
				<input type="password" name="password" id="password" placeholder="Password"></input>
				<input type="password" name="repeatedPassword" id="password" placeholder="Enter Password Again"></input>
				<input type="text" name="subject" id="subject" placeholder="Subject"></input>
				<input type="text" name="email" id="email" placeholder="Email"></input>
				<input type="submit" class="submit" value="Sign Up!" name="teacherSubmit"></input>
			</form>
		</div>
	</div>

	<div class="log-sign-btn">
		<button><a href="log_in.php">Log In</a></button>
	</div>
	
</div>
</body>
</html>