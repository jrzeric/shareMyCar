function login() {
	console.log('Getting token...');
	var x = new XMLHttpRequest();
	x.open('GET', 'http://localhost:8080/sharemycar/webapp/apis/login.php', true);
	x.setRequestHeader('email', document.getElementById('email').value);
	x.setRequestHeader('password', document.getElementById('password').value);
	x.send();
	x.onreadystatechange = function() {
		if (x.readyState == 4 && x.status == 200) {
			var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
			if (JSONdata.status == 0) {
				sessionStorage.authenticated = true;
				if (JSONdata.user.id.role.id == 'P')
				{
					sessionStorage.userId = JSONdata.user.id.id;
					sessionStorage.userRole = JSONdata.user.id.role.name;
					sessionStorage.userName = JSONdata.user.id.name;
					sessionStorage.userLastName = JSONdata.user.id.lastName;
					sessionStorage.userSecondLastName = JSONdata.user.id.secondLastName;
					sessionStorage.userUniversity = JSONdata.user.id.university.name;
					sessionStorage.userUniversityLat = JSONdata.user.id.university.location.latitude;
					sessionStorage.userUniversityLon = JSONdata.user.id.university.location.longitude;
					sessionStorage.userLocationLat = JSONdata.user.id.location.latitude;
					sessionStorage.userLocationLon = JSONdata.user.id.location.longitude;
					sessionStorage.userControlNumber = JSONdata.user.id.controlNumber;
					sessionStorage.userCellPhone = JSONdata.user.id.cellphone;
					sessionStorage.userEmail = JSONdata.user.id.email;
					sessionStorage.token = JSONdata.token;
					if (JSONdata.user.id.studentId == "") 
					{
						window.location = 'imagen.html';
					}
					else window.location = 'homePassenger.html';
				}
				else
				{
					sessionStorage.userId = JSONdata.user.id.id;
					sessionStorage.userRole = JSONdata.user.id.role.name;
					sessionStorage.userName = JSONdata.user.id.name;
					sessionStorage.userLastName = JSONdata.user.id.lastName;
					sessionStorage.userSecondLastName = JSONdata.user.id.secondLastName;
					sessionStorage.userUniversity = JSONdata.user.id.university.name;
					sessionStorage.userUniversityLat = JSONdata.user.id.university.location.latitude;
					sessionStorage.userUniversityLon = JSONdata.user.id.university.location.longitude;
					sessionStorage.userLocationLat = JSONdata.user.id.location.latitude;
					sessionStorage.userLocationLon = JSONdata.user.id.location.longitude;
					sessionStorage.userControlNumber = JSONdata.user.id.controlNumber;
					sessionStorage.userCarBrand = JSONdata.user.id.car.brand.name;
					sessionStorage.carImage = JSONdata.user.id.car.brand.photo;
					sessionStorage.userCarModel = JSONdata.user.id.car.model.name;
					sessionStorage.userYear = JSONdata.user.id.car.year;
					sessionStorage.userLicensePlate = JSONdata.user.id.car.licensePlate;
					sessionStorage.userCellPhone = JSONdata.user.id.cellphone;
					sessionStorage.userEmail = JSONdata.user.id.email;
					sessionStorage.token = JSONdata.token;
					console.log(JSONdata.user.id.studentId);
					if (JSONdata.user.id.studentId == "") 
					{
						window.location = 'imagesDriver.html';
					}
					else window.location = 'homeDriver.html';
				}
				console.log(sessionStorage.userUniversityLon);
				console.log(JSONdata.user.id.university.location.longitude);
			}
			else{
				document.getElementById('error').innerHTML = JSONdata.errorMessage;
			}
		}
	}

}
