//variables
var popupVisible = false;

//resize event
window.onresize = function() {
	centerPopup();
}

function centerPopup() {
	//only if popup is visible
	if (popupVisible) {
		//get glass and popup
		var glass = document.getElementById('glass');
		var popup = document.getElementById('popup');
		//get measurements
		getMeasurements();
		//glass size
		glass.style.height = bodyHeight + 'px';
		//center popup
		popup.style.top = ((clientHeight - popup.offsetHeight) / 2) + 'px';
		popup.style.left = ((clientWidth - popup.offsetWidth) / 2) + 'px';

	}
}
function showPopup(title, width, height) {
	//popup visible
	popupVisible = true;

	//body
	var body = document.getElementsByTagName('body')[0];
	//get document height
	var documentHeight = document.documentElement.offsetHeight;
	//create glass
	var glass = document.createElement('div');
	glass.id = 'glass';
	body.appendChild(glass);
	//create popup window
	var popup = document.createElement('div');
	popup.id = 'popup';
	popup.style.width = width + 'px';
	popup.style.height = height + 'px';
	//create title
	var popupTitle = document.createElement('div');
	popupTitle.id = 'popuptitle';
	popupTitleText = document.createElement('h1');
	popupTitleText.innerHTML = title;
	popupTitle.appendChild(popupTitleText);
	popup.appendChild(popupTitle);

	//popup close button
	var popupClose = document.createElement('div');
	popupClose.id='popupclose';
	popupClose.innerHTML='X';
	popupClose.setAttribute('onclick', 'closePopup()');
	popup.appendChild(popupClose);
	//create content
	var popupContent = document.createElement('div');
	popupContent.id = 'popupcontent';
	popup.appendChild(popupContent);
	//create buttons
	var popupButtons = document.createElement('div');
	popupButtons.id = 'popupbuttons';
    /*
	var buttonNeutral = document.createElement('button');
	buttonNeutral.className = 'popupbuttonneutral';
	buttonNeutral.innerHTML = 'Neutral';
	popupButtons.appendChild(buttonNeutral);
	var buttonNegative = document.createElement('button');
	buttonNegative.className = 'popupbuttonnegative';
	buttonNegative.innerHTML = 'Negative';
	popupButtons.appendChild(buttonNegative);
    *//*
    labeluser = document.createElement('label');
    labeluser.className='loginlabelu';
    labeluser.innerHTML='User';
     popupContent.appendChild(labeluser);
    */
    textuser = document.createElement('input');
    textuser.className='userLogin';
    textuser.setAttribute('type','email');
    textuser.setAttribute('placeholder','Email');
		textuser.setAttribute('id', 'textMail');
    popupContent.appendChild(textuser);
    /*
    labelpass = document.createElement('label');
    labelpass.className='loginlabelp';
    labelpass.innerHTML='Password';
     popupContent.appendChild(labelpass);
    */
    textpass = document.createElement('input');
    textpass.className='userPass';
    textpass.setAttribute('type','password');
    textpass.setAttribute('placeholder','Password');
		textpass.setAttribute('id', 'textPassword');
    popupContent.appendChild(textpass);

  var buttonLogin = document.createElement('button');
	buttonLogin.className = 'buttonlogin';
	buttonLogin.setAttribute('id', 'loginButton');
	buttonLogin.innerHTML = 'Login';
	buttonLogin.setAttribute('onclick', 'showinfo()');
	popupButtons.appendChild(buttonLogin);
	popup.appendChild(popupButtons);

	//add popup to body
	body.appendChild(popup);

	//center popup
	centerPopup();

	var getbuttonloginpop = document.getElementById("buttonloginpop");
	getbuttonloginpop.setAttribute('onclick', 'closePopup()');

}

function closePopup(){
	//get glass and popup
	var glass = document.getElementById('glass');
	var popup = document.getElementById('popup');
	//get parent
	var parentOfGlass=glass.parentElement;
	var parentOfPopup=popup.parentElement;
	//the parent kill their childen >:c
	parentOfGlass.removeChild(glass);
	parentOfPopup.removeChild(popup);
	var getbuttonloginpop = document.getElementById("buttonloginpop");
	getbuttonloginpop.setAttribute('onclick', "showPopup('Login',400, 400)");
}

function showinfo()
{
	var text1 = document.getElementById('textMail').value;
	var text2 = document.getElementById('textPassword').value;
	alert(text1+' '+text2);
}

//var new Area= new Popupwindow('new area' , 500, 300);
//newArea.setContent(.....);
//newArea.addcustomButton('Search', Search());
//newArea.showCancelButton('cancel()');
//newArea.showOkButton('postArea()');
//newArea.show();
