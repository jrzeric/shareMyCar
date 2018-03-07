var marker;  //variable del marcador
var coords = {lat:32.459952 ,lng: -116.825524}; //coordenadas obtenidas con la geolocalización

function initMap ()
{
      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('map'),
      {
        zoom: 13,
        center:new google.maps.LatLng(coords.lat,coords.lng),
      });

      //Creamos el marcador en el mapa con sus propiedades
      //para nuestro obetivo tenemos que poner el atributo draggable en true
      //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat,coords.lng),

      });
      //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
      //cuando el usuario a soltado el marcador
      marker.addListener('click', toggleBounce);

      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
        document.getElementById("coords").value = this.getPosition().lat()+","+ this.getPosition().lng();
      });
}

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

// Carga de la libreria de google maps

function finish()
{
  //personal info
  var txtFirstName = document.getElementById('firtname').value;
  var txtLastName = document.getElementById('lastname').value;
  var txtSurName = document.getElementById('surname').value;
  //contact info
  var txtCellPhone = document.getElementById('cellphone').value;
  var txtEmail = document.getElementById('email').value;
  var txtPassword = document.getElementById('password').value;
  var txtRePassword = document.getElementById('repassword').value;
  //school information
  var txtControlNumber = document.getElementById('controlnumber').value;
  var comboStateSchool = document.getElementById('stateSchool').value;
  var comboAmpm = document.getElementById('ampm').value;
  if (txtPassword === txtRePassword) {
    alert("datos a registrar: Personal: \n firtname: "+txtFirstName+" lastname: "+
          txtLastName+" Surname: "+txtSurName+"\n"+"Contact: \n"+"Cellphone: "+txtCellPhone+" Email: "+
          txtEmail+" Password: "+txtPassword+"\n"+"School information: \n"+"Control number: "+txtControlNumber+" State school: "+
          comboStateSchool+" Ampm: "+comboAmpm+" Latitude: "+coords.lat+" Longitude: "+coords.lng);
  }
  else {
    alert("PASSWORD ISN'T THE SAME");
  }
}
