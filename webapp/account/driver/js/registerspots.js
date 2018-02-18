var map;
var spots;
var meet;

var markers = [];
//var coordinates = [[sessionStorage.userLocationLat, sessionStorage.userLocationLon]];
//Declaracion de variables
var coordinates = [];
var valid = 1;

function init() 
{
  	map = new google.maps.Map(document.getElementById('map'), 
  	{
    	zoom: 10,
    	center: new google.maps.LatLng(32.537063, -117.048211),
    	mapTypeId: google.maps.MapTypeId.ROADMAP
  	});
    
    // This event listener will call addMarker() when the map is clicked.
    map.addListener('click', function(event) 
    {
      addMarker(event.latLng);
    });

    
  	// Adds a marker at the center of the map.
  	addHome();
  	addUniversity();
}


// Adds a marker to the map and push to the array.
function addHome() 
{
  var location = new google.maps.LatLng(32.537063, -117.048211);
	var marker = new google.maps.Marker(
	{
	    position: location,
	     icon: 'http://localhost:8080/sharemycar/webapp/account/driver/img/iconhome.png',
	    map: map
	 });

}

// Adds a marker to the map and push to the array.
function addUniversity() 
{
  var location = new google.maps.LatLng(32.460157, -116.825552);
  var marker = new google.maps.Marker(
  {
    position: location,
     icon: 'http://localhost:8080/sharemycar/webapp/account/driver/img/iconschool.png',
    map: map
  });
}



// Adds a marker to the map and push to the array.
function addMarker(location) 
{
	var marker = new google.maps.Marker(
	{
	  position: location,
	  map: map
	});
  var contentString = "<div align = 'center'><br><label>Time at you pass: </label><br><input type='text'><br><br><label>Price of this spot: </label><br><input type='text'><div class='buttons'><button class='buttonOK' onClick=addTravel()>Save</button></div></div>'";
    console.log(contentString);
    var infowindow = new google.maps.InfoWindow({
          	content: contentString
        });

    marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
}//addMarker


function addTravel() 
{

}//RegisterSpots-