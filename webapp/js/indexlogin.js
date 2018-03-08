function login()
{
	console.log('Getting token...');
	var x = new XMLHttpRequest();
	x.open('GET', 'http://sharemycar.local.net/apis/login.php', true);
	var email = document.getElementById('textMail').value;
	var pass = document.getElementById('textPassword').value;
	console.log(pass);
	console.log(email);
	x.setRequestHeader('email', email);
	x.setRequestHeader('password', pass);
	x.send();
	x.onreadystatechange = function() {
		if (x.readyState == 4 && x.status == 200) {
			var JSONdata = JSON.parse(x.responseText); console.log(JSONdata);
				sessionStorage.authenticated = true;
				if (JSONdata.status == 0)
				{
					sessionStorage.driver = 0;
					
					sessionStorage.userId = JSONdata.user.usuario.id;
					sessionStorage.userName = JSONdata.user.user.surname;
					sessionStorage.userLastName = JSONdata.user.user.secondSurname;
					sessionStorage.userSecondLastName = JSONdata.user.user.secondLastName;
					sessionStorage.userEmail = JSONdata.user.user.email;
					sessionStorage.userCellPhone = JSONdata.user.user.cellPhone;
					sessionStorage.userControlNumber = JSONdata.user.user.controlNumber;
					sessionStorage.userLatitude = JSONdata.user.user.latitude;
					sessionStorage.userLongitude = JSONdata.user.user.longitude;
					sessionStorage.userPhoto = JSONdata.user.user.photo;
					sessionStorage.userRaiting = JSONdata.user.user.raiting;

					sessionStorage.userUniversityLat = JSONdata.user.user.university.latitude;
					sessionStorage.userUniversityLon = JSONdata.user.user.university.longitude;
					sessionStorage.userUniversity = JSONdata.user.user.university.name;

					sessionStorage.userCityId = JSONdata.user.user.city.code;
					sessionStorage.userCityName = JSONdata.user.user.city.name;

					if (JSONdata.user.user.status == 2) 
					{
						alert("You haven't validated your email, please validate it first please");
					}
					else
					{
						if (JSONdata.user.user.status == 3) 
						{
							alert("Firstly you'll pick your role in the aplication");
							//window.location = 'registeras.php'
						}
						else
						{
							alert("You are a passenger");
						}
					}
					
				}
				else
					if (JSONdata.status == 1) 
					{
						sessionStorage.driver = 1;

						sessionStorage.userId = JSONdata.user.usuario.id;
						sessionStorage.userName = JSONdata.user.user.surname;
						sessionStorage.userLastName = JSONdata.user.user.secondSurname;
						sessionStorage.userSecondLastName = JSONdata.user.user.secondLastName;
						sessionStorage.userEmail = JSONdata.user.user.email;
						sessionStorage.userCellPhone = JSONdata.user.user.cellPhone;
						sessionStorage.userControlNumber = JSONdata.user.user.controlNumber;
						sessionStorage.userLatitude = JSONdata.user.user.latitude;
						sessionStorage.userLongitude = JSONdata.user.user.longitude;
						sessionStorage.userPhoto = JSONdata.user.user.photo;
						sessionStorage.userRaiting = JSONdata.user.user.raiting;

						sessionStorage.userUniversityLat = JSONdata.user.user.university.latitude;
						sessionStorage.userUniversityLon = JSONdata.user.user.university.longitude;
						sessionStorage.userUniversity = JSONdata.user.user.university.name;

						sessionStorage.userCityId = JSONdata.user.user.city.code;
						sessionStorage.userCityName = JSONdata.user.user.city.name;

						sessionStorage.BrandName = JSONdata.user.car.model.brand.name;

						sessionStorage.ModelName = JSONdata.user.car.model.name;

						sessionStorage.licensePlate = JSONdata.user.car.licensePlate;
						sessionStorage.driverLicense = JSONdata.user.car.driverLicense;
						sessionStorage.color = JSONdata.user.car.color;
						sessionStorage.insurance = JSONdata.user.car.insurance;
						sessionStorage.spaceCar = JSONdata.user.car.spaceCar;
						sessionStorage.owner = JSONdata.user.car.owner;

						if (JSONdata.user.user.status == 2) 
						{
							alert("You haven't validated your email, please validate it first please");
						}
						else
						{
							alert("You are a driver");
						}
					}
					else 
						alert(JSONdata.errorMessage);
		}
	}
}