var currentlyOpened = null;

//button not disapearing
$(document).ready(function() {
	$("h3").click(function() {
		if (currentlyOpened != null) {
			if (currentlyOpened.attr("id") == $(this).attr("id")) {
				toggleDisplay($(this));
				currentlyOpened = null;
			} else {
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
	$header.nextUntil("h3").css("display", function() {
		console.log($(this));
		console.log($(this).css("display"));
		var currentStyle = $(this).css("display");
		if (currentStyle == "none") {
			$(this).css("display", "table-row");
		} else {
			$(this).css("display", "none");
		}	
		console.log($(this).css("display"));
		console.log("-------------------------------")
	});
}