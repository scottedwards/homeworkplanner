<?php 
function uploadFiles($files, $dir) {
	// Count the number of uploaded files in array
	$total = count($files['name']);

	// Loop through each file
	for($i=0; $i<$total; $i++) {
		//Get the temp file path
		$tmpFilePath = $files['tmp_name'][$i];

	  	//Make sure we have a filepath
		if ($tmpFilePath != ""){
			//check to make sure that a file doesnt already exist with the same name
			//if the file exists, keep incrementing a number at the end of the file
			
			//DO THIS NEXT

    		//Setup our new file path
			$newFilePath = "./homework_$dir/" . $_FILES['upload']['name'][$i];

    		//Upload the file into the temp dir
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {

      		//Handle other code here

			}
		}
	}
}
?>