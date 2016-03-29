function addRowToTree(row, arg, sortingTree) {
	//get the id for each homework so we can identify each title/date after sorting
		//i shall input the sorting data along with its associating ID
		var homeworkID = row.find("h3").attr("id");
		if (arg == "title") {
			//get the title for the homework
			var title = row.find("h3").text();
			//add the title and id to the binary tree as a "tuple" but really its just an array 
			sortingTree.addNode([homeworkID, title]);
		} else if(arg == "date") {
			//get the due date for the homework
			var dueDate = row.find("td").attr("dueDate");
			//add the due date and the id to the binary tree
			sortingTree.addNode([homeworkID, dueDate]);
		}
}

function sortBy(arg) {
	console.log("Sorting by " + arg + "...");
	var sortingTree = new BinaryTree();

	//sort due-in table
	$("#due-in > tbody > tr").each(function() {
		addRowToTree($(this), arg, sortingTree);
	});
	var sortedList = sortingTree.getOrderedValues();
	
	for (var i = 1; i <= sortedList.length - 1; i++) {
		var row = $("#" + sortedList[i][0]).closest("tr");
		var rowAbove = $("#" + sortedList[i-1][0]).closest("tr");

		row.insertAfter(rowAbove);
	}

	//sort passed table
	sortingTree = new BinaryTree();
	$("#passed-table > tbody > tr").each(function() {
		addRowToTree($(this), arg, sortingTree);
	});
	var sortedList = sortingTree.getOrderedValues();
	
	for (var i = 1; i <= sortedList.length - 1; i++) {
		var row = $("#" + sortedList[i][0]).closest("tr");
		var rowAbove = $("#" + sortedList[i-1][0]).closest("tr");

		row.insertAfter(rowAbove);
	}
	
	/*
	//loop through each tr in the table with the id 'homework-table'
	$("#due-in > tbody > tr").each(function() {
		//get the id for each homework so we can identify each title/date after sorting
		//i shall input the sorting data along with its associating ID
		var homeworkID = $(this).find("h3").attr("id");
		if (arg == "title") {
			//get the title for the homework
			var title = $(this).find("h3").text();
			//add the title and id to the binary tree as a "tuple" but really its just an array 
			sortingTree.addNode([homeworkID, title]);
		} else if(arg == "date") {
			//get the due date for the homework
			var dueDate = $(this).find("td").attr("dueDate");
			//add the due date and the id to the binary tree
			sortingTree.addNode([homeworkID, dueDate]);
		}
	});
	*/

	
}

