/*			Mysql	*/
/*Host		:Localhost */
/*Database	:sharemycar/database/DDL.sql */

/*Fecha de creacion: 12/FEB/2018 */
/*----------------------------------------------------------------------------------------------------------------------------------*/

use sharemycar;

/*----------------------------------------------------------------------------------------------------------------------------------*/

/*Update from states*/
update states_ctg set name = 'prueba', status = 1 where id = 'BCN';

/*Update from cities*/
update cities_ctg set name = 'prueba', state = 'BCN', status = 1 where id = 1;

/*Update from universities*/
update universities_ctg set name = 'prueba', city = 1, latitude = 'prueba', longitude = 'prueba', status = 1 where id = 'UTT';

/*Update from student*/
update students set name = 'prueba', surname = 'prueba', secondSurname = 'prueba', email = 'prueba@gmail.com' , cellPhone = 'prueba', university = 'UTT', controlNumber = 'prueba', latitude = 'prueba', longitude = 'prueba', photo = 'prueba', city = 1, turn = 1, profile = 'USE', status = 1 where id = 1;  

/*Update from brand*/
update brands_ctg set name = 'prueba', image = 'prueba', status = 1 where id = 1;

/*Update from model*/
update models_ctg set name = 'prueba', brand = 1, status = 1 where id = 1;

/*Update from car*/
update cars set driver = 1, model = 1, licencePlate = 'prueba',driverLicence = 'prueba', color = 'prueba', insurance = 'prueba', spaceCar = 4, owner = 'prueba', status = 1 where id = 1;

/*Update from spot*/
update spots set pay = 12, hour = '06:30:00',day = 'Monday', status = 1 where id = 1;


/*Update from ride*/
update ride set timeArrived ='06:30:00', timeFinish = '06:50:00',calificationPass = 3, calificationDriv = 4 where id = 1 and spot = 1 and passenger = 1; 

/*Update from reportoption*/
update reportOption set description = 'prueba' where id = 1;

/*Update from report*/
update reports set reportoption = 1, dateOfReport = '20181010', ride = 1, whoReport = 1, status = 1 where id = 1;

/*Update from timeban*/
update timeban set description = 'prueba' where id = 1;

/*Update from banlist*/
update banlist set reportman = 1, timeban = 1, status = 1 where id = 1;
