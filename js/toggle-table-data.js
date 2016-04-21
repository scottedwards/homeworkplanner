var currentlyOpened = null;

//this is to handle an element that has been clicked which was created by PHP
$(document).ready(function() {
	//when a heading 3 is clicked run the following function
	$("h3").click(function() {
		//if there is an open homework then do the following
		if (currentlyOpened != null) {
			//if the heading clicked is the currently open homework then toggle its display settings
			//and set currently open to null
			//$(this) is the jQuery syntax to get the object that this function currently belongs to
			if (currentlyOpened.attr("id") == $(this).attr("id")) {
				toggleDisplay($(this));
				currentlyOpened = null;
			} else {
				//if the heading clicked is different to the currently open heading then toggle both display settings
				//then making currently open to to homework that was just clicked
				toggleDisplay(currentlyOpened);
				toggleDisplay($(this));
				currentlyOpened = $(this);
			}
		} else {
			toggleDisplay($(this));	
			currentlyOpened = $(this);
		}	
	});
});

function toggleDisplay($header) {
	//iterates down the DOM until it finds a heading 3
	$header.nextUntil("h3").css("display", function() {
		//set currentStyle to the current element in the loop's CSS display property
		var currentStyle = $(this).css("display");
		if (currentStyle == "none") {
			//if the display property is none, make it table-row
			$(this).css("display", "table-row");
		} else {
			//if its table-row, make it none
			$(this).css("display", "none");
		}	
	});
}