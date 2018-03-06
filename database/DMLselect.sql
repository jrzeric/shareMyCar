/*			Mysql	*/
/*Host		:Localhost */
/*Database	:sharemycar/database/DDL.sql */

/*Fecha de creacion: 09/FEB/2018 */
/*----------------------------------------------------------------------------------------------------------------------------------*/

use sharemycar;

/*----------------------------------------------------------------------------------------------------------------------------------*/

/*selects from states*/
select id, name, status from states_ctg;
select id, name, status from states_ctg where id = 1;

/*select from cities*/
select id, name, state, status from cities_ctg;
select id, name, state, status from cities_ctg where id = 1;
select c.id, c.name, s.id, s.name, c.status from cities_ctg as c join states_ctg as s on c.state = s.id;
select c.id, c.name, s.id, s.name, c.status from cities_ctg as c join states_ctg as s on c.state = s.id where c.id = 1;

/*select  from universities*/
select id, name, city, latitude, longitude, status from universities_ctg;
select id, name, city, latitude, longitude, status from universities_ctg where id = 'UTT';
select u.id, u.name, c.id,c.name, c.state, u.latitude, u.longitude, u.status from universities_ctg as u join cities_ctg as c on u.city = c.id;

/*select from profile*/
select id, name from profiles_ctg;

/*select from student*/
select id, name,surname, secondSurname, email, cellPhone, university, controlNumber, latitude, longitude, photo, city, turn, raiting, profile, status from students;
select id, name,surname, secondSurname, email, cellPhone, university, controlNumber, latitude, longitude, photo, city, turn, raiting, profile, status from students where id = 1;
select s.id, s.name, s.surname, s.secondSurname, s.email, s.cellPhone, s.latitude, s.longitude, u.id, u.name, u.city, u.latitude, u.longitude, c.id, c.name, c.state, s.status from students as s join universities_ctg as u on s.university = u.id join cities_ctg as c on s.city = c.id join profiles_ctg as p on s.profile = p.id;
Select s.id, s.name, s.surName, s.secondSurName, s.email, s.password, s.cellPhone, u.id universityId,
					u.name universityName, c.id cityId, c.name cityName, c.status cityStatus, st.id stateId, st.name stateName,
					st.status stateStatus, u.latitude universityLt, u.longitude universityLg, u.status universityStatus,
					s.controlNumber, s.latitude, s.longitude, s.photo, c.id ctUnId, c.name ctUnName, c.status ctUnStts, st.id stUniId,
					st.name stUniName, st.status stUnSta, s.turn, s.raiting, s.status, p.id idProfile, p.name profileName
					FROM students s JOIN universities_ctg u ON s.university = u.id JOIN cities_ctg c ON s.city = c.id
					JOIN states_ctg st ON c.state = st.id JOIN profiles_ctg p ON s.profile = p.id JOIN cities_ctg ci ON u.city = ci.id
					WHERE s.id = 1;

select * from students;
select u.id,u.name,c.name,c.state,u.latitude,u.longitude from universities_ctg as u inner join cities_ctg as c on u.city=c.id;
select * from universities_ctg;

select *from cars where(select driver from cars) in (select id from students);
/*select from brand*/
select id, name, image, status from brands_ctg;
select id, name, image, status from brands_ctg where id = 1;

/*select from model*/
select id, name, brand, status from models_ctg;
select id, name, brand, status from models_ctg where id = 1;

/*select from car*/
select id, driver, model, licencePlate, driverLicence, color, insurance, spaceCar, owner, status from cars;
select id, driver, model, licencePlate, driverLicence, color, insurance, spaceCar, owner, status from cars where id = 1;
select c.id, c.model, c.licencePlate, c.driverLicence, c.color, c.insurance, c.spaceCar, c.owner, c.driver, s.name, s.surname, s.secondSurname, s.email, s.cellPhone, s.university, s.controlNumber, s.latitude, s.longitude, s.photo, s.city, s.turn, s.profile, s.status  from cars as c join students as s on c.driver = s.id;
select c.id, c.model, c.licencePlate, c.driverLicence, c.color, c.insurance, c.spaceCar, c.owner, c.driver, s.name, s.surname, s.secondSurname, s.email, s.cellPhone, s.university, s.controlNumber, s.latitude, s.longitude, s.photo, s.city, s.turn, s.profile, s.status  from cars as c join students as s on c.driver = s.id where c.id = 1;

/*select from spot*/
select id, driver, latitude, longitude, pay, hour, day, status from spots;
select id, driver, latitude, longitude, pay, hour, day, status from spots where id = 1;
select id, driver, latitude, longitude, pay, hour, day, status from spots where driver = 1;
select s.id, s.driver, s.longitude, s.longitude, s.pay, s.hour, s.day, st.id,  st.name,  st.surname,  st.secondSurname, st.email, st.cellPhone, st.university, st.controlNumber, st.latitude, st.longitude, st.latitude, st.longitude, st.photo, st.city, st.turn, st.profile, s.status from spots as s join students as st on s.driver = st.id;

/*<<<<<<< HEAD */

/*select from ride*/
select id, spot, passenger, timeArrived, timeFinish, calificationPass, calificationDriv from ride;
select id,spot, passenger, timeArrived, timeFinish, calificationPass, calificationDriv from ride where id = 1;
/*=======*/
/*select destination*/
select id, driver, university, timeArrivedSchool from destination;
select id, driver, university, timeArrivedSchool from destination where id = 1;
select d.id, d.timeArrivedSchool, s.id, s.name, s.surname, s.secondSurname, s.email, s.cellPhone, s.controlNumber,s.latitude, s.longitude, s.photo, s.turn, s.profile, u.id, u.name, u.latitude, u.longitude, s.city, s.status from destination as d join students as s on d.driver = s.id join universities_ctg as u on d.university = u.id;

/*select from ridePassenger*/
select spot, passenger, destination, picked_at, timeArrivedDriver, status from ridePassenger;
select spot, passenger, destination, picked_at, timeArrivedDriver, status from ridePassenger where id = 1; /* this need a change ?*/
select r.picked_at, r.timeArrivedDriver, s.id as spotID, s.driver, s.latitude, s.longitude,s.pay, s.timeArrived, st.id as PassengerID, st.name, st.surname, st.secondSurname,st.email, st.cellPhone, st.controlNumber, st.latitude, st.longitude, st.photo, st.turn, st.profile, d.id as destinationID, d.driver, d.university, d.timeArrivedSchool, r.status from ridepassenger as r join spots as s on r.spot=s.id join students as st on r.passenger=st.id join destination as d on r.destination=d.id;
/*>>>>>>> dashboard-improve-v2*/

/*Todos los spots de un driver que recogieron un pasajero*/
select s.id as idSpot, s.latitude, s.longitude, s.pay, s.hour, s.day, r.id as idRide, r.passenger, r.timeArrived, r.timeFinish, r.calificationPass, r.calificationDriv from spots as s join ride as r on r.spot = s.id where s.driver = 2;

/*Todos los spots de un driver que recogieron un pasajero un dia determinado*/
select s.id as idSpot, s.latitude, s.longitude, s.pay, s.hour, s.day, r.id as idRide, r.passenger, r.timeArrived, r.timeFinish, r.calificationPass, r.calificationDriv from spots as s join ride as r on r.spot = s.id where s.driver = 2 and s.day = 'Martes';
/*End select from ride*/


/*selects from reportoption*/
select id, description from reportOption;

/*selects from report*/
select id, reportoption, dateOfReport, ride, whoReport, status from reports;
select r.id, r.dateOfReport, r.ride, r.whoReport,ro.id, ro.description,s.driver, r.status from reports as r join reportOption as ro on r.reportOption = ro.id join ride as ri on r.ride = ri.id join spots as s on ri.spot = ri.id;

/*selects * from timeban*/
select id, description from timeban;

/*selects from banlist*/
select id, reportman, timeban, status from banlist;
select id, reportman, timeban, status from banlist where id = 1;
select b.id, t.id, t.description, s.id, s.name, b.status from banlist as b join students as s on b.reportman = s.id join timeban as t on b.timeban = t.id;
