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





function childOf( node, ancestor ) {
    var child = node;
    while (child !== null) {
		if (child === ancestor) return true;
		try {
			if (child.id === ancestor.id) return true;
		}
		catch(e) {
			console.log("Gimme more marks Martin pls");
		}
        child = child.parentNode;
    }
    return false;   
}

// code for opening and closing modals
window.onclick = function(event) {

	//add ID's to be used later;
	$('.ui-datepicker-buttonpane').attr("id","datepickerBtn");
	$('.ui-datepicker-header').attr("id","datepickerHeader");

	var modal = $('#modal').get(0);
	var button = $('.button');
	var datepicker = $('#ui-datepicker-div').get(0);
	var btnPane = $('#datepickerBtn').get(0);
	var dpHeader = $('#datepickerHeader').get(0);

	if($('body').hasClass('modal-active')) {
		if (modal !== event.target && !childOf(event.target, modal) && datepicker !== event.target 
			&& !childOf(event.target, datepicker) && btnPane !== event.target && !childOf(event.target, btnPane) 
			&& dpHeader !== event.target && !childOf(event.target, dpHeader)) {  
				removeModal();
		}
	}
	else if(event.target.className == 'button')
	{
		showModal();
	}
}

function addCloseClickEvent() {
	$('#close').on("click", function(ev) {
		removeModal();
	});
}

function removeModal() {
	$('#modal-container').addClass('out');
	$('body').removeClass('modal-active');
	// Allows the closing animation to run
	setTimeout(deleteModalData, 200);
}

function showModal() {
	$('#modal-container').removeAttr('class').addClass('modalBtn');
	$('body').addClass('modal-active');
}

function deleteModalData() {
	$('.modalToDelete').remove();
}

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

function addToDropDownList(array, parent, htmla, id) {
	$.each(array, function(key, value) {
		switch(id)
		{
			case 'genre' :
				htmla += "<option value=\"" + value.genreID + "\">" + value.genreName + "</option>";
				break;
			case 'artist' :
				htmla += "<option value=\"" + value.artistID + "\">" + value.artistName + "</option>";
				break;
			case 'venue' :
				htmla += "<option value=\"" + value.venueID + "\">" + value.venueName + ", " + value.venueLocation + "</option>";
				break;
		}
	});

	htmla += "</select>";
	$(parent).append(htmla);
}

function getDropdownData(url, parent, id) {
	$.get(url, function(myData) {
		var arr = $.map(myData, function(el) { return el; })
		addToDropDownList(arr, parent, '<select class="form-control" name="' + id + '" id="' + id + '" required>', id)
	});
}

function getPopulatedDropdownData(url, parent, id, selectedID) {
	$.get(url, function(myData) {
		var arr = $.map(myData, function(el) { return el; });
		addToDropDownList(arr, parent, '<select class="form-control" name="' + id + '" id="' + id + '" required>', id);
		$("#" + id).val(selectedID);
	});
}

$('.buyTickets').on('click', function(ev) {
	ev.preventDefault();
	// Extra client side validation to stop people buying tickets for events that are sold out
	if($(this).attr('soldOut') != 'true') {
		var showID = $(this).attr('id');
		var ticketsAvailable = $(this).attr('numOfTickets');
		var ticketPrice = $(this).attr('ticketPrice');
		var lblTicketsAvailable = "There are " + parseFloat(ticketsAvailable).toFixed(0) + " tickets left for this show!"
	
		$.ajax({
			type: "POST",
			url: "/events-website/includes/buyTickets.inc.html",
			success: function(data) {
				$('#ModalContent').html(data);
				$('#lblNumOfTickets').text(lblTicketsAvailable);
				$('#showID').val(showID);
				$('#numofTicketsLeft').val(ticketsAvailable);
				$('#ticketPrice').val(ticketPrice);
				addCloseClickEvent();
				showModal();
			},
			error: function() {
				alert("Modal data failed to load");
			}
		});
	}
});

$('#addArtist').on('click', function(ev) {
	ev.preventDefault();
		$.post('/events-website/includes/addartist.inc.html', function (data) {
			$('#ModalContent').html(data);
			addCloseClickEvent();
			showModal();
	});
});

$('#addGenre').on('click', function(ev) {
	ev.preventDefault();
		$.post('/events-website/includes/addgenre.inc.html', function (data) {
			$('#ModalContent').html(data);
			addCloseClickEvent();
			showModal();
	});
});

$('#addVenue').on('click', function(ev) {
	ev.preventDefault();
		$.post('/events-website/includes/addvenue.inc.html', function (data) {
			$('#ModalContent').html(data);
			addCloseClickEvent();
			showModal();
	});
});

$('#addEvent').on('click', function(ev) {
	ev.preventDefault();
	$.ajax({
		type: "POST",
		url: "/events-website/includes/addevent.inc.html",
		success: function(data) {
			debugger;
			$('#ModalContent').html(data);
			getDropdownData('cms/db-get/getgenre.php', "#genreDropdown", "genre");
			getDropdownData('cms/db-get/getartist.php', "#artistDropdown", "artist");
			addCloseClickEvent();
			showModal();
		},
		error: function() {
			alert("Modal data failed to load");
		}
	});
});

$('#editEvent').on('click', function(ev) {
	ev.preventDefault();
	var eventID = $(this).attr('eventID');
	var genreID = 0;
	var artistID = 0;

	$.post('cms/db-get/getevent.php', { id: eventID },
		function (data) {
			var name = data.Name;
			var details = data.Details;
			artistID = data.ArtistID;
			genreID = data.GenreID;

			$.post('/events-website/includes/editevent.inc.html', function (data) {
				$('#ModalContent').html(data);
				getPopulatedDropdownData('cms/db-get/getgenre.php', "#genreDropdown", "genre", genreID);
				getPopulatedDropdownData('cms/db-get/getartist.php', "#artistDropdown", "artist", artistID);
				$('#name').val(name);
				$('#details').val(details);
				$('#eventID').val(eventID);
				addCloseClickEvent();
				showModal();
		});
	});
});

$('#addShow').on('click', function(ev) {
	ev.preventDefault();
	var eventID = $(this).attr('eventID');

	$.ajax({
		type: "POST",
		url: "/events-website/includes/addshow.inc.html",
		success: function(data) {
			$('#ModalContent').html(data);
			getDropdownData('cms/db-get/getvenue.php', "#venueDropdown", "venue");
			$('#dp').datetimepicker({
				controlType: 'select',
				oneLine: true,
				timeFormat: 'hh:mm tt'
			});
			$('#eventID').val(eventID);
			addCloseClickEvent();
			showModal();
		},
		error: function() {
			alert("Modal data failed to load");
		}
	});
});





//functionality for showing the sticky navbar
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if ($(document).width() > 600 && (document.body.scrollTop > 215 || document.documentElement.scrollTop > 215)) {
	$("#stickyBar").show(200);
  } else {
	$("#stickyBar").hide(300);
  }
}

//maybe use?
function addDynamicModalStyling() {
	var height = window.innerHeight * 0.65;
	var footerheight = $('.modal-footer').height();
	var headheight = $('.modal-header').height();
	var content = $('.modal-body');

	var step1 = (height - headheight);
	var availableheight = (step1 - footerheight);
	$('.modal-body').css({"height" : availableheight, "overflow" : "auto"});
}