function init() 
{

	var fn = document.getElementById('firstname');
	var ln = document.getElementById('lastname');
	var sn = document.getElementById('secondlastname');
	var u = document.getElementById('university');
	var r = document.getElementById('role');
	var cn = document.getElementById('controlNumber');
	fn.value = sessionStorage.userName;
	ln.value = sessionStorage.userLastName;
	sn.value = sessionStorage.userSecondLastName;
	u.value = sessionStorage.userUniversity;
	r.value = sessionStorage.userRole;
	cn.value = sessionStorage.userControlNumber;
	console.log(sessionStorage.userUniversityLon);
	var locations = [
      ['Tu universidad ' + sessionStorage.userUniversity, sessionStorage.userUniversityLat, sessionStorage.userUniversityLon],
      ['Tu casa', sessionStorage.userLocationLat, sessionStorage.userLocationLon]
    ];
	if (sessionStorage.userRole == 'Driver')
	{
		var b = document.getElementById('brand');
		var m = document.getElementById('model');
		var y = document.getElementById('year');
		var lp = document.getElementById('licensePlate');
		var dl = document.getElementById('DriverLicense');

		b.innerHTML = sessionStorage.userCarBrand;
		m.innerHTML = sessionStorage.userCarModel;
		y.innerHTML = sessionStorage.userYear;
		lp.innerHTML = sessionStorage.userLicensePlate;
		dl.innerHTML = sessionStorage.userDriverLicense;
	}//if

	var map = new google.maps.Map(document.getElementById('map'),
	{
      zoom: 10,
      center: new google.maps.LatLng(sessionStorage.userLocationLat, sessionStorage.userLocationLon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++)
    {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

}

function spotRegister()
{
	window.location = 'spots.html';
}
