$(document).ready(function() {
    var venueName = $('#venueName').text().trim();
    var venueLocation = $('#venueLocation').text().trim();

    var geocoder = new google.maps.Geocoder();
    var address = venueName + ", " + venueLocation;
    var venueLatLng = 0;
 
    if (geocoder) {
       geocoder.geocode({ 'address': address }, function (results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
             venueLatLng = results[0].geometry.location;
             var myOptions = {           
                 center: venueLatLng,           
                 zoom: 16,           
                 mapTypeId: google.maps.MapTypeId.ROADMAP        
             }; 
             var gMap = new google.maps.Map(document.getElementById("googleMap"), myOptions);
             
             var myMarker = new google.maps.Marker({ 
                 position: venueLatLng,    
                 map: gMap,    
                 title: venueName,    
                 draggable: false
             });
         
             var service = new google.maps.places.PlacesService(gMap);
             service.nearbySearch({
               location: venueLatLng,
               radius: 3500,
               type: ['parking']
             }, function(response, status) {callback(response, status, venueLatLng)});
         
             var myInfowindow = new google.maps.InfoWindow({
                 content: venueName
             });
             
             google.maps.event.addListener(myMarker, 'click', function() {    
                 myInfowindow.open(gMap,myMarker); 
             });
          }
          else {
             console.log("Geocoding failed: " + status);
          }
       });
    }   
    // var  = new google.maps.LatLng(53.488093, -2.243677); 
});

function callback(results, status, venueLatLng) {
    if (status === google.maps.places.PlacesServiceStatus.OK) {
        var counter = results.length;
        if(results.length > 5) {
            counter = 5; 
        }
        var listOfCarParks = new Array();
      for (var i = 0; i < counter; i++) {
        createParkingList(results[i], listOfCarParks, venueLatLng);
      }
      displayClosestCarParks(listOfCarParks);
    }
}

function createParkingList(place, listOfCarParks, venueLatLng) {
    var placeName = place.name;
    var placeLoc = place.geometry.location;
    var placeaddress = place.vicinity;    
    var placeLoc = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
    var metersBetween = google.maps.geometry.spherical.computeDistanceBetween(venueLatLng, placeLoc);
    var milesAway = metersBetween / 1609.344;
    var carPark = new CarPark(placeName, placeLoc, placeaddress, milesAway);
    listOfCarParks.push(carPark);
}

function CarPark(name, loc, address, milesAway){
    this.name = name;
    this.loc = loc;
    this.address = address;
    this.milesAway = milesAway
  }

  function displayClosestCarParks(listOfCarParks) {
      listOfCarParks.sort(sortByMilesAway);

      listOfCarParks.forEach(carPark => {
        var parentDiv = document.createElement("div");
        parentDiv.className = "showsItem";     

        var milesDiv = document.createElement("div");
        milesDiv.className = "showDate";        
        
        var detailsDiv = document.createElement("div");
        detailsDiv.className = "showDetails";

        var milesAway = document.createElement("span");
        var milesText = document.createElement("span");
        milesAway.innerHTML = carPark.milesAway.toFixed(2);
        milesAway.className = "showText dateNo"        
        milesText.innerHTML = "miles away";
        milesText.className = "showText"
        milesDiv.append(milesAway, milesText);

        var name = document.createElement("span");
        var address = document.createElement("span");
        name.innerHTML = carPark.name;
        address.innerHTML = carPark.address;
        name.className = "showText highlightedText carParkName";
        address.className = "showText";
        detailsDiv.append(name, address);

        parentDiv.append(milesDiv, detailsDiv);
        $('#listOfCarParks').append(parentDiv);
      });
  }

function sortByMilesAway(a,b) {
if (a.milesAway < b.milesAway)
    return -1;
if (a.milesAway > b.milesAway)
    return 1;
return 0;
}