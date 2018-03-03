

function validatepass(){

  var password = document.getElementById('password').value;
  console.log(password);
  var passvalidate = document.getElementById('repassword').value;
  console.log(passvalidate);
  var parent = document.getElementById('parentContact');
  var label = document.getElementById('labelPassvalidate');

  label.style.float ="right";
  label.style.marginRight = "480px";
  label.style.fontSize = "16pt";

  if(password != "" && passvalidate != ""){
    if(password == passvalidate){
      label.style.color = "#00FF00";
      label.innerHTML = 'Password correct';
    }else if(password != passvalidate){
      label.style.color = "#FF0000";
      label.innerHTML = 'Password incorrect';
    }
  }else {
    label.style.color = "#FFF";
  }
}
