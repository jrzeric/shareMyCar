/*			Mysql	*/
/*Host		:Localhost */
/*Database	:sharemycar/database/DDL.sql */

/*Fecha de creacion: 09/FEB/2018 */
/*----------------------------------------------------------------------------------------------------------------------------------*/

use sharemycar;

/*----------------------------------------------------------------------------------------------------------------------------------*/

/*Insert into states*/
insert into states_ctg(id, name) values ('BCN','Baja California'),('SON','Sonora'),('BCS','Baja California Sur');

/*Insert into cities*/
insert into cities_ctg(name, state) values ('Tijuana','BCN'),('Tecate','BCN'),('Playas','BCN'),('Hermosillo','SON');

/*insert into Universities*/
insert into universities_ctg(id, name, city, latitude, longitude) values ('UTT','Universidad Tecnologica de Tijuana',1,'32.460915', '-116.824267'),
('ITT','Instituto Tecnologico de Tijuana',1,'32.529062', '-116.986837'),('UABC','Universidad Autonoma de Baja California',1,'32.533770', '-116.963781');

/*insert into profiles*/
insert into profiles_ctg(id, name) values('ADM', 'Administrador'),('USE', 'User');

/*insert into students*/
insert into students(name, surname, secondSurname, email, password, cellPhone, university, controlNumber,latitude, longitude, photo, city,turn, profile)
values('Fernando', 'Coronel', 'Salinas', '0316113444@miutt.edu.mx', 'aaaa','664-123-45-67','UTT','0316113444','32.510902', '-116.922555',default,1,0,'USE'),
('Alejandro', 'Angulo', 'Garcia', '0316113445@miutt.edu.mx', 'bbbb', '664-123-45-68', 'UTT', '0316113445', '32.457411', '-116.872631',default,1,0,'USE'),
('Eric', 'Juarez', 'Juarez', '0316113446@miutt.edu.mx', 'cccc','664-123-45-69','UTT','0316113446','32.497781', '-116.965114',default,1,0,'USE'),
('Pablo', 'Alvarez', 'Lagarra', '0316113447@miutt.edu.mx', 'dddd','664-123-45-70','UTT','0316113447','32.495649', '-116.932146',default,1,0,'USE');

select s.email, s.id, s.profile from students as s where s.email = '0316113444@miutt.edu.mx' AND s.password = 'aaaa';

/*insert into brands*/
insert into brands_ctg(name, image) values('FORD',default),('Honda',default),('Toyota',default);

/*insert into models*/
insert into models_ctg(name, brand) values('Focus', 1),('Fiesta', 1),('Fusion', 1),('Civic', 2),('accord', 2),('Fit', 2),
('Corolla', 3),('Tacoma', 3),('Celica', 3);

/*insert into cars*/
insert into cars(driver, model, licencePlate, driverLicence, color, insurance,spaceCar, owner) 
values(2,1,'1234567890','410041011','white','664-132-12-32',4,'Alejandro Angulo');

/*Insert into spot*/
insert into spots(driver,latitude, longitude, pay, hour, day) 
values(2,'32.495647', '-116.932144',15,'06:45:00','Lunes'),(2,'32.495648', '-116.932145',10,'06:55:00','Lunes');


/*insert into ride*/
insert into ride(spot, passenger, timeArrived, timeFinish,calificationPass,calificationDriv)
values(1,1,'06:30:00','06:55:00',4,3),(1,2,'06:25:00','06:53:00',5,4);

/*insert into reportOption*/
insert into reportOption(description) values('Llego tarde'),('Fue Grosero'),('Manejo imprudente');

/*insert into reports*/
insert into reports(reportoption, ride, whoReport) values(1,1,1),(1,1,1);

/*inser into timeBan*/
insert into timeban(description) values('1 semana'),('3 semana'),('4 semanas'),('Permanente');

/*insert into banlist*/
insert into banlist(reportman, timeban) values('4',1);


