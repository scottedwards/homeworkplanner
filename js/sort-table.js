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
	} else if(arg == "mark") {
		//if the user wants to sort by marks then get the mark in the textbox
		var mark = row.find("#mark").val();
		//if the mark is equal to nothing (like if a textbox doesn't exist due to the pupil ont submitting homework)
		//then make it equal to -1, the reason for this being that we want these pupls to be at the bottom of the list
		if (mark == null) {
			mark = -1;
		}
		//add the minus sign in from of mark so that it sorts it in reverse order (from highest mark to lowest mark)
		//this will make the -1 from above to +1 and so these pupils will have the greatest values, and so will be
		//at the end of the sorted list
		sortingTree.addNode([rowID, -mark]);
	}
}

function sortBy(arg) {
	//loop through each table in the page
	$("table").each(function() {
		var sortingTree = new BinaryTree();
		//loop through each row for the current table in the loop
		$(this).find("tr").each(function() {
			//add row to the binary tree
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
			//check what the sort data is
			if ($(this).attr("id") == "passed-table" && arg == "date") {
				row.insertBefore(rowAbove);
			} else {
				row.insertAfter(rowAbove);
			}
		}
	});
}

