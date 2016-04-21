<?php 
function uploadFiles($files, $dir, $homeworkID, $username) {
	// Count the number of uploaded files in array
	$total = count($files['name']);

	// Loop through each file
	for($i=0; $i<$total; $i++) {
		//Get the temp file path
		//this path is where the file is stored temporarily 
		//until it is either uploaded to the server or rejected
		$tmpFilePath = $files['tmp_name'][$i];

	  	//Make sure we have a filepath
		if ($tmpFilePath != ""){
			//check to make sure that a file doesnt already exist with the same name
			//if the file exists, keep incrementing a number at the end of the file
			
			//DO THIS NEXT

    		//Setup our new file path
    		//file exists needs a file path on a hard drive not a URL so $_SERVER['DOCUM.... is used to get
    		//current root directory
			$newFilePath = $_SERVER['DOCUMENT_ROOT'] . "/homeworkplanner/homework_$dir/";
			$newFilePath .= pathinfo($files['name'][$i], PATHINFO_FILENAME) ."(0).";
			$newFilePath .= pathinfo($files['name'][$i], PATHINFO_EXTENSION);

			findUniqueName($newFilePath, 0);

    		//'Upload' the file from the temp directory to the directory we want to save it in
    		move_uploaded_file($tmpFilePath, $newFilePath);
    		
    		//replace all single quotes in the path with double qoutes to escape them from the query
    		//otherwise sql will interpret any apostraphies as the end of a data stream
    		$newFilePath = str_replace("'", "''", $newFilePath);
    		$path = str_replace($_SERVER['DOCUMENT_ROOT'], "http://localhost:8888", $newFilePath);

    		//now add the file to the homework planner database in the correct table
    		$conn = new mysqli("localhost", "root", "root", "homework_planner");
    		if ($dir == "resources") {
    			$addResourceSql = "INSERT INTO `homework_resources`
    				(`homework_id`, `path`) 
    				VALUES 
    				('$homeworkID', '$path')";
    			$conn->query($addResourceSql);
    		} elseif ($dir == "submissions") {
    			$addSubmissionSql = "INSERT INTO `homework_submissions`
    				(`homework_id`, `pupil_id`, `path`, `mark`)
    				VALUES
    				('$homeworkID', '$username', '$path', '')";
    			$conn->query($addSubmissionSql);
    		}
		}
	}
}

//the file name parameter is passed by reference as for some reason even though I got the function to work by value, it would return
//nothing so I couldnt write:
// ** $newFilePath = findUniqueName($newFilePath, 0); **
//this meant that in order to change the variable $newFilePath I had to pass it by reference so that any changes made to the 
//fileName in the function would affect the variable passed as the parameter outside of the functions scope
function findUniqueName(&$fileName, $counter) {
	//check if the file exists, if it does make the number added on the end of the file
	//increase and call this subroutine again. If it doesnt exist then output it as a valid filename
	if (file_exists($fileName)) {
		//get what the previous number added to the file wouldve been
		$previousNumber = "($counter)";
		//create a new one
		$counter += 1;
		$newNumber = "($counter)";
		//now swap the old number with the new one
		$fileName = str_replace($previousNumber, $newNumber, $fileName);
		findUniqueName($fileName, $counter);
	}
}
?>