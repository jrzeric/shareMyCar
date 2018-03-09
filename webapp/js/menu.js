function actionMenu(id)
{
    if (document.getElementById(id).style.visibility == 'hidden') {
        document.getElementById(id).style.visibility='visible';
        document.getElementById(id).style.width='250px';
        document.getElementById('section').style.width='calc(100% - 250px)';
    }  else  {
        document.getElementById(id).style.visibility='hidden';
        document.getElementById(id).style.width='0px';
        document.getElementById('section').style.width='100%';
    }
    initMenu();
}

function initMenu()
{
	document.getElementById("rating").innerHTML = "Raiting: &#x2605; " + sessionStorage.userRaiting;
	document.getElementById("name").innerHTML = sessionStorage.userName + " " + sessionStorage.userLastName + " " + sessionStorage.userSecondLastName;
    document.getElementById("city").innerHTML = sessionStorage.userCityName;
    document.getElementById("university").innerHTML = sessionStorage.userUniversity;
	document.getElementById('photo').style.backgroundImage = "url('"+ sessionStorage.userPhoto +"')";
}

function logout()
{
	sessionStorage.clear();
	window.location = "../../index.php";
}

function profile()
{
	window.location = "profile.php"
}