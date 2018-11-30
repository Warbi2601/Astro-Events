$(window).on('resize', function(ev){
	//console.info(window.innerWidth);
	if(window.innerWidth > 600){
		$('nav ul').attr('style','');
	};
});

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px and add a black background color to body */
function openNav() {
	$("#mySidenav").css({"box-shadow": "250px 0px 150px 300px rgba(0, 0, 0, 1)", "width": "50%"});
	//document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
	$('#mySidenav').css({"box-shadow": "none"});
	document.getElementById("mySidenav").style.width = "0";
	document.getElementById("main").style.marginLeft = "0";
    document.body.style.backgroundColor = "white";
}

$(document).ready(function() {
	$('.lastUpdated').text("Page Last Updated: " + new Date(document.lastModified).toLocaleDateString("en-GB"));
});



//Modal JS


// // Get the button that opens the modal
// var btn = document.getElementById("myBtn");

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// // When the user clicks on the button, open the modal
// btn.onclick = function() {
//     modal.style.display = "block";
// }

// // When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//     modal.style.display = "none";
// }

// // When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// }








// code for opening and closing modals

window.onclick = function(event) {

	var modal = document.getElementsByClassName('modal');
	var button = $('.button');
	if($('body').hasClass('modal-active')) {

		if($(event.target).parents('.modal').length == 0 && $(event.target).hasClass('modal') == false) {
			removeModal();
		}
	}
	else if(event.target.className == 'button')
	{
		$('#modal-container').removeAttr('class').addClass('modalBtn');
		$('body').addClass('modal-active');
	}
}

$('body').on("click", "span", function(ev) {
	removeModal();
})

function removeModal() {
	$('#modal-container').addClass('out');
	$('body').removeClass('modal-active');
	// Allows the closing animation to run
	setTimeout(deleteModalData, 200);
}

function deleteModalData() {
	$('.modalToDelete').remove();
}

// code for building dynamic modals

$('.button').on("click", function(ev) {
	var BtnID = event.target.id;

	switch(BtnID)
	{
		//Add Event
		case 'addEvent' :
		//Header
		$('.modal').append('<div class="modalToDelete"></div>');
		$('.modalToDelete').append('<div class="modalForm"></div>');
		$('.modalForm').append('<form action="cms/process/loginscript.php" method="POST" id="addEventForm"></form>');
		$('#addEventForm').append('<div class="modal-header"></div>');
		$('.modal-header').append('<span class="close">&times;</span>');
		$('.modal-header').append('<h2>Add Event</h2>');

		//Body
		$('#addEventForm').append('<div class="modal-body"></div>');

		$('.modal-body').append('<div class="inputBox"></div>');
		$('.inputBox:nth-child(1)').append('<span class="requiredField">*</span>');
		$('.inputBox:nth-child(1)').append('<input type="text" name="name" id="name" placeholder="Event Name" required>');
		$('.inputBox:nth-child(1)').append('<br />');

		$('.modal-body').append('<div class="inputBox"></div>');
		$('.inputBox:nth-child(2)').append('<span class="requiredField">*</span>');
		$('.inputBox:nth-child(2)').append('<input type="text" name="details" id="details" placeholder="Event Details" required>');
		$('.inputBox:nth-child(2)').append('<br />');

		$('.modal-body').append('<div class="inputBox"></div>');
		$('.inputBox:nth-child(3)').append('<span class="requiredField">*</span>');

		//@EXAMPLE OF DROPDOWN MENUS

		var selectList = '<select class="form-control" name="artist" id="artist" required>';

		var arrayFromPHP = ["Saab", "Volvo", "BMW"];
		addToDropDownList(arrayFromPHP, ".inputBox:nth-child(3)", selectList);

		$('.inputBox:nth-child(3)').append('<br />');

		//Footer
		$('#addEventForm').append('<div class="modal-footer"></div>');
		$('.modal-footer').append('<div class="inputBox" id="footer"></div>');
		$('#footer').append('<input type="submit" value="Add Event" class="btnStandard" required>');
		$('#footer').append('<br />');
		break;

		//Edit Event
		case 'editEvent' :
		//Header
		$('.modal').append('<div class="modalToDelete"></div>');
		$('.modalToDelete').append('<div class="modal-header"></div>');
		$('.modal-header').append('<span class="close">&times;</span>');
		$('.modal-header').append('<h2>Edit Event</h2>');

		//Body
		$('.modalToDelete').append('<div class="modal-body"></div>');
		$('.modal-body').append('<div class="form"></div>');
		$('.modal-body').append('<form action="cms/process/loginscript.php" method="POST"></form>');
		
		$('.modal-body').append('<div class="inputBox"></div>');
		$('.modal-body').append('<span class="requiredField">*</span>');
		$('.modal-body').append('<input type="text" name="name" id="name" placeholder="Event Name" required>');
		$('.modal-body').append('<br />');

		$('.modal-body').append('<div class="inputBox"></div>');
		$('.modal-body').append('<span class="requiredField">*</span>');
		$('.modal-body').append('<input type="text" name="details" id="details" placeholder="Event Details" required>');
		$('.modal-body').append('<br />');

		//Footer
		$('.modalToDelete').append('<div class="modal-footer"></div>');
		$('.modal-footer').append('<div class="inputBox"></div>');
		$('.modal-footer').append('<input type="submit" value="Add Event" class="btnStandard" required>');
		$('.modal-footer').append('<br />');
		break;
	}

	var height = window.innerHeight * 0.65;
	var footerheight = $('.modal-footer').height();
	var headheight = $('.modal-header').height();
	var content = $('.modal-body');

	var step1 = (height - headheight);
	var availableheight = (step1 - footerheight);
	$('.modal-body').css({"height" : availableheight, "overflow" : "auto"});
})

$(window).resize(function() {
	if($('body').hasClass('modal-active')) {
		var height = window.innerHeight * 0.65;
		var footerheight = $('.modal-footer').height();
		var headheight = $('.modal-header').height();
		var content = $('.modal-body');

		var step1 = (height - headheight);
		var availableheight = (step1 - footerheight);
		$('.modal-body').css({"height" : availableheight, "overflow" : "auto"});
	}
});

function addToDropDownList(array, parent, htmla) {
	debugger;
	for (var x = 0; x < array.length; x++) {
		htmla += "<option>" + array[x] + "</option>";
	}
	htmla += "</select>";

	$(parent).append(htmla);
}