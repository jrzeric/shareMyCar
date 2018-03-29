//measurements
var bodyHeight = 0;
var bodyWidth = 0;
var clientHeight = 0 ;
var clientWidth = 0 ;
var scrollTop = 0;
var scrollLeft = 0;

//get measurements
function getMeasurements()
{
	bodyHeight = document.documentElement.offsetHeight;
	bodyWidth = document.documentElement.offsetWidth;
	clientHeight = window.innerHeight;
	clientWidth = window.innerWidth;
	scrollTop = window.pageYOffset;
	scrollLeft = window.pageXOffset;
}

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

    var	labelpass = document.createElement('label');
    labelpass.className='loginlabelp';
    labelpass.innerHTML='Are you Save Changes?';
    popupContent.appendChild(labelpass);


  var buttonYes = document.createElement('button');
	buttonYes.className = 'buttonYes';
	buttonYes.setAttribute('id', 'butonyes');
	buttonYes.innerHTML = 'Yes';
	/*buttonYes.setAttribute('onclick', 'login()');*/
	popupButtons.appendChild(buttonYes);
	popup.appendChild(popupButtons);

	var buttonNo = document.createElement('button');
	buttonNo.className = 'buttonNo';
	buttonNo.setAttribute('id', 'buttonno');
	buttonNo.innerHTML = 'No';
	buttonNo.setAttribute('onclick', 'closeAll()');
	popupButtons.appendChild(buttonNo);
	popup.appendChild(popupButtons);

	//add popup to body
	body.appendChild(popup);

	//center popup
	centerPopup();

	var getbuttonloginpop = document.getElementById("Save_Button");
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
	var getbuttonloginpop = document.getElementById("Save_Button");
	getbuttonloginpop.setAttribute('onclick', "showPopup('Save changes',400, 200)");
}

function closeAll(){
closePopup();
Close();

}



function Edit()
{
document.getElementById('Save_Button').style.display="inline"
document.getElementById('Cancel_Button').style.display="inline";
document.getElementById('Edit_Button').style.display="none";
document.getElementById("profile_name").readOnly = false;
document.getElementById("lastName").readOnly = false;
document.getElementById("email").readOnly = false;
document.getElementById("cellPhone").readOnly = false;
document.getElementById("profile_university").readOnly = false;
document.getElementById("controlNumber").readOnly = false;
document.getElementById("profile_city").readOnly = false;
document.getElementById("state").readOnly = false;
}

function Close(){
document.getElementById('Save_Button').style.display = "none";
document.getElementById('Cancel_Button').style.display = "none";
document.getElementById('Edit_Button').style.display="inline";
document.getElementById("profile_name").readOnly = true;
document.getElementById("lastName").readOnly = true;
document.getElementById("email").readOnly = true;
document.getElementById("cellPhone").readOnly = true;
document.getElementById("profile_university").readOnly = true;
document.getElementById("controlNumber").readOnly = true;
document.getElementById("profile_city").readOnly = true;
document.getElementById("state").readOnly = true;

}
