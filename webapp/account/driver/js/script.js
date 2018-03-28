/*
  needed change the id's of the input's for introduce the car information, this need the same spaces of the information
  of student, we can take them and only puts the new information
*/
function hiddenElements()
{
  if (document.getElementById('txtName_txtmodel').innerHTML === 'Model') //compairing if the text are changed
  {
    alert("now is show the student information");
    document.getElementById('txtName_txtmodel').innerHTML = 'Name';
    document.getElementById('txtLastName_txtLicensePlate').innerHTML = 'LastName';
    document.getElementById('txtEmail_txtDriverLicense').innerHTML = 'Email';
    document.getElementById('txtCellPhone_txtColor').innerHTML = 'CellPhone';
    document.getElementById('txtUniversity_txtInsurance').innerHTML = 'University';
    document.getElementById('txtControlNumber_txtSpaceCar').innerHTML = 'ControlNumber';
    document.getElementById('txtCity_txtOwner').innerHTML = 'City';
    document.getElementById('profileTitle').innerHTML = 'Profile';

    document.getElementById('personalInformationTitle').style.display = 'block';
    document.getElementById('collageInformationTitle').style.display = 'block';
  }
  else
  {
    alert("now is show the car information");
    document.getElementById('txtName_txtmodel').innerHTML = 'Model';
    document.getElementById('txtLastName_txtLicensePlate').innerHTML = 'LicensePlate';
    document.getElementById('txtEmail_txtDriverLicense').innerHTML = 'DriverLicense';
    document.getElementById('txtCellPhone_txtColor').innerHTML = 'Color';
    document.getElementById('txtUniversity_txtInsurance').innerHTML = 'Insurance';
    document.getElementById('txtControlNumber_txtSpaceCar').innerHTML = 'SpaceCar';
    document.getElementById('txtCity_txtOwner').innerHTML = 'Owner';
    document.getElementById('profileTitle').innerHTML = 'Car information';

    document.getElementById('personalInformationTitle').style.display = 'none';
    document.getElementById('collageInformationTitle').style.display = 'none';
  }


}
