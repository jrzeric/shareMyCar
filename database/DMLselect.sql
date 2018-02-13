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
select id, name,surname, secondSurname, email, cellPhone, university, controlNumber, latitude, longitude, photo, city, turn, profile, status from students;
select id, name,surname, secondSurname, email, cellPhone, university, controlNumber, latitude, longitude, photo, city, turn, profile, status from students where id = 1;
select s.id, s.name, s.surname, s.secondSurname, s.email, s.cellPhone, s.latitude, s.longitude, u.id, u.name, u.city, u.latitude, u.longitude, c.id, c.name, c.state, s.status from students as s join universities_ctg as u on s.university = u.id join cities_ctg as c on s.city = c.id join profiles_ctg as p on s.profile = p.id;
select s.id, s.name, s.surname, s.secondSurname, s.email, s.cellPhone, s.latitude, s.longitude, u.id, u.name, u.city, u.latitude, u.longitude, c.id, c.name, c.state, s.status from students as s join universities_ctg as u on s.university = u.id join cities_ctg as c on s.city = c.id join profiles_ctg as p on s.profile = p.id where s.id = 1;

/*select from brand*/
select id, name, image, status from brands_ctg;
select id, name, image, status from brands_ctg where id = 1;

/*select from model*/
select id, name, brand, status from models_ctg;
select id, name, brand, status from models_ctg where id = 1;

/*select from car*/
select id, driver, model, licencePlate, driverLicence, color, insurance, owner, status from cars;
select id, driver, model, licencePlate, driverLicence, color, insurance, owner, status from cars where id = 1;
select c.id, c.model, c.licencePlate, c.driverLicence, c.color, c.insurance, c.owner, c.driver, s.name, s.surname, s.secondSurname, s.email, s.cellPhone, s.university, s.controlNumber, s.latitude, s.longitude, s.photo, s.city, s.turn, s.profile, s.status  from cars as c join students as s on c.driver = s.id;
select c.id, c.model, c.licencePlate, c.driverLicence, c.color, c.insurance, c.owner, c.driver, s.name, s.surname, s.secondSurname, s.email, s.cellPhone, s.university, s.controlNumber, s.latitude, s.longitude, s.photo, s.city, s.turn, s.profile, s.status  from cars as c join students as s on c.driver = s.id where c.id = 1;

/*select from spot*/
select id, driver, latitude, longitude,pay, timeArrived, status from spots;
select id, driver, latitude, longitude,pay, timeArrived, status from spots where id = 1;
select s.id, s.driver, s.longitude, s.longitude, s.pay, timeArrived, st.id,  st.name,  st.surname,  st.secondSurname, st.email, st.cellPhone, st.university, st.controlNumber, st.latitude, st.longitude, st.latitude, st.longitude, st.photo, st.city, st.turn, st.profile, s.status from spots as s join students as st on s.driver = st.id;


/*select from ride*/
select id, spot, timeArrived, latitudeEnd, longitudeEnd, timeArrivedSchool, spaceCar, groupPassenger, status from ride;
select id, spot, timeArrived, latitudeEnd, longitudeEnd, timeArrivedSchool, spaceCar, groupPassenger, status from ride where id = 1;
select r.id, r.spot, r.timeArrived, r.latitudeEnd, r.longitudeEnd, r.timeArrivedSchool, r.spaceCar, r.groupPassenger, s.id, s.driver, s.latitude, s.longitude, s.pay,s.timeArrived, r.status from ride  as r join spots as s on r.spot = s.id;

/*select from ridePassenger*/
select ride, spot, request_at, picked_at from ridePassenger;

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

