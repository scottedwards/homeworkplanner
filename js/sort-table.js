function addRowToTree(row, arg, sortingTree) {
	//get the id for each homework so we can identify each title/date after sorting
		//i shall input the sorting data along with its associating ID
		var rowID = row.find("h3").attr("id");
		if (arg == "title") {
			//get the title for the homework
			var title = row.find("h3").text();
			//add the title and id to the binary tree as a "tuple" but really its just an array 
			sortingTree.addNode([rowID, title]);
		} else if(arg == "date") {
			//get the due date for the homework
			var dueDate = row.find("td").attr("dueDate");
			//add the due date and the id to the binary tree
			sortingTree.addNode([rowID, dueDate]);
		} else if(arg == "date") {
			var mark = row.find("#mark").text();
			sortingTree.addNode([rowID, mark]);
		}
}

function sortBy(arg) {
	//initialise a new BinaryTree object
	var sortingTree = new BinaryTree();

	//sort due-in table
	//loop through each table row in the table with id due-in and add pass it to the function addRowToTree
	$("#due-in > tbody > tr").each(function() {
		addRowToTree($(this), arg, sortingTree);
	});

	//get the sorted list of headings from the binary tree
	//these will be in the form of a "tuple" where the heading ID will be the 0 index
	var sortedList = sortingTree.getOrderedValues();
	//loop through each row in the sorted list
	//start from 1 as we want to place all the other rows after the top one, so it's needless to alter the position
	//this also means I don't need to write a condition in the loop to make sure "sortedList[i-1]" is inside the bounds 
	//of the array beacuse if I started from 0 the index would be -1 and so it would result in an error
	for (var i = 1; i <= sortedList.length - 1; i++) {
		//using jQuery function .closest to search for the closest table row (tr) with the ID from the first index of
		//the heading tuple, once again, this tuple consists of an ID to identify the row, and a title/date to sort
		var row = $("#" + sortedList[i][0]).closest("tr");
		//get the row that is before the current row in the sorting order
		var rowAbove = $("#" + sortedList[i-1][0]).closest("tr");
		//place the current row after the row that precedes it in the orderedList
		row.insertAfter(rowAbove);
	}

	//sort passed table
	//loop through each table row in the table with id passed-table and add pass it to the function addRowToTree
	sortingTree = new BinaryTree();
	$("#passed-table > tbody > tr").each(function() {
		addRowToTree($(this), arg, sortingTree);
	});

	//the folowwing code is exactly the same as the loop above but for a different table
	var sortedList = sortingTree.getOrderedValues();
	
	for (var i = 1; i <= sortedList.length - 1; i++) {
		var row = $("#" + sortedList[i][0]).closest("tr");
		var rowAbove = $("#" + sortedList[i-1][0]).closest("tr");

		row.insertAfter(rowAbove);
	}
}

