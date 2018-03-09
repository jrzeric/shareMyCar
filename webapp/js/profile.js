function initProfilePassenger()
{
	console.log(sessionStorage.userName);
	document.getElementById("nameInput").value = sessionStorage.userName;
	document.getElementById("lastNameInput").value = sessionStorage.userLastName;
	document.getElementById("emailInput").value = sessionStorage.userEmail;
	document.getElementById("cellPhoneInput").value = sessionStorage.userCellPhone;
	document.getElementById("universityInput").value = sessionStorage.userUniversity;
	document.getElementById("controlNumberInput").value = sessionStorage.userControlNumber;
	document.getElementById("cityInput").value = sessionStorage.userCityName;
	document.getElementById("stateInput").value = sessionStorage.userStateName;

	var image = document.getElementById("imgProfile");

	image.setAttribute("src", sessionStorage.userPhoto);
}