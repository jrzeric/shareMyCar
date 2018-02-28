/*			Mysql	*/
/*Host		:Localhost */
/*Database	:sharemycar/database/DDL.sql */

/*Fecha de creacion: 10/FEB/2018 */
/*----------------------------------------------------------------------------------------------------------------------------------*/
drop database if exists sharemycar;

create database if not exists sharemycar;

use sharemycar;

/*----------------------------------------------------------------------------------------------------------------------------------*/

/*state documentation
	@param id:		identifier of the table states_ctg
    @param name:	name of the state
    @param status:	1 for active, 0 for disable
	@comment:		this table is use to admin all about the state
*/
create table if not EXISTS states_ctg
(
	id CHAR(3),
	name varchar(30) not null,
	status bit default 1,
	PRIMARY KEY (id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*city documentation
	@param id:		identifier of the table cities_ctg
    @param name:	name of the city
    @param state:	is a foreign key of the table states_ctg
    @param status:	1 for active, 0 for disable
    @comment:		this table is use to admin all about the city
*/
create table if NOT EXISTS cities_ctg
(
	id smallint AUTO_INCREMENT,
	name varchar(30) not null,
	state char(3) not null,
	status bit default 1,
	PRIMARY KEY (id),
	FOREIGN KEY (state) REFERENCES states_ctg(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*university documentation

	@param id:			identifier of the table universities_ctg
    @param name:		name of the university
    @param city:		is a foreign key of the table cities_ctg
    @param latitude:	is the latitude of the unversity
    @param longitude:	is the longitude of the unversity
    @param status:		1 for active, 0 for disable
    @comment:			this table is use to admin all about the university
*/
create table if NOT EXISTS universities_ctg
(
	id char(4),
	name VARCHAR(60) not null,
	city smallint not null,
	latitude varchar(18) not null,
	longitude varchar(18) not null,
	status bit default 1,
	PRIMARY KEY (id),
    FOREIGN KEY (city) REFERENCES cities_ctg(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*profile documentation

	@param id:		identifier of the table profiles_ctg
    @param name:	name of the profile
    @comment:		ADM-Administrador, PAS-Passenger, DRI-Driver
    @comment:		this table is use to assign a profile to a user
*/
CREATE TABLE IF NOT EXISTS profiles_ctg
(
	id char(3),
	name VARCHAR(13) unique not null,
	PRIMARY KEY (id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;
select * from profiles_ctg;

/*student documentation
	@param id:				identifier of the table students
    @param name:			name of the student
    @param surname:			surname of the student
    @param secondSurname:	second surname of the student
    @param email:			email of the student
	@param cellPhone:		cellphone of the student
    @param university:		is a foreign key of the table universities_ctg
	@param controlNumber:	the number of the control in the school
    @param licenceNumber:	number of the licence car
	@param latitude:		is the latitude of the student
    @param longitude:		is the longitude of the student
    @param photo:			phot of the student
    @param city:			is a foreign key of the table cities_ctg
    @param turn:			witch turn isthe student study 0-morning, 1-afternoon
    @param profile:			is a foreign key of the table profiles_ctg
    @param status:			1 for active, 0 for disable
    @comment:				this table is use to admin all information about the student
*/
CREATE TABLE IF NOT EXISTS students
(
	id SMALLINT AUTO_INCREMENT,
	name varchar(30) not null,
    surname varchar(30) not null,
	secondSurname varchar(30),
	email varchar(60) UNIQUE not null,
	cellPhone char(13) UNIQUE not null,
	university char(4) not null,
	controlNumber varchar(15) not null,
    latitude varchar(18) not null,
	longitude varchar(18) not null,
	photo varchar(90) DEFAULT 'vacio',
	city smallint not null,
    turn bit default 0, /* 0 for matutino 1 for vespertino*/
	status bit default 1 not null,
    profile char(3) not null,
	PRIMARY KEY (id),
	FOREIGN KEY (profile) REFERENCES profiles_ctg(id),
	FOREIGN KEY (university) REFERENCES universities_ctg(id),
	FOREIGN KEY (city) REFERENCES cities_ctg(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*brand documentation

	@param id:			identifier of the table brands_ctg
    @param name:		name of the brand
    @param image:		image of the brand
    @param status:		1 for active, 0 for disable
    @comment:			this table is use to add more brands
*/
create table if not EXISTS brands_ctg
(
 	id tinyint AUTO_INCREMENT,
    name VARCHAR(30) not null,
    image varchar(60) not null default 'vacio',
    status bit default 1,
    PRIMARY KEY (id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*model documentation
	@param id:			identifier of the table models_ctg
    @param name:		name of the model
    @param brand:		is a foreign key of the table brands_ctg
    @param status:		1 for active, 0 for disable
    @comment:			this table is use to create models for a car
*/
CREATE TABLE IF NOT EXISTS models_ctg
(
	id tinyint AUTO_INCREMENT,
	name varchar(30) not null,
    brand tinyint,
	status bit default 1,
	PRIMARY KEY (id),
	FOREIGN KEY (brand) REFERENCES brands_ctg(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*car documentation

	@param id:				identifier of the table cars
    @param driver:			is a foreign key of the table student
    @param model:			is a foreign key of the table model_ctg
	@param licencePlate:	licence plate of the car
    @param driverLicence:	licence number of the driver(student)
    @param color:			color of the car
    @param insurance:		number of the insurance(dont have idea)
    @param spaceCar:		number of seat of the car
    @param owner:			owner of the car will be use
    @param status:			1 for active, 0 for disable
    @comment:				this table is use to administrate all about the car
*/
CREATE TABLE IF NOT EXISTS cars
(
	id int auto_increment,
	driver smallint not null,
	model tinyint not null,
	licencePlate varchar(10) not null,
	driverLicence varchar(10) not null,
	color varchar(10) not null,
	insurance varchar(15) not null,
    spaceCar int not null,
	owner varchar(20) not null,
	status bit default 1,
	PRIMARY KEY (id),
	FOREIGN KEY (driver) REFERENCES students(id),
	FOREIGN KEY (model) REFERENCES models_ctg(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*spot documentation

	@param id:				identifier of the table spot
    @param driver:			is a foreign key of the table student
    @param latitude:		is the latitude of the spot
    @param longitude:		is the longitude of the spot
	@param pay:				for decide
    @param hour:			whitch time the driver pass that spots
	@param day:				whitch day the driver pass that spots
    @param status:			1 for active, 0 for disable
    @comment:				this table is use to know all about the spot create of the driver
*/
CREATE TABLE IF NOT EXISTS spots/* point where the driver going on*/
(
	id int AUTO_INCREMENT,
	driver SMALLINT not null,
	latitude varchar(18) not null,
	longitude varchar(18) not null,
	pay decimal,
	hour time not null,
	day varchar(9) not null,
	status bit default 1,
	primary key(id),
	FOREIGN KEY (driver) REFERENCES students(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*destination documentation
	
    @param id:			id of the table destination
    @param driver:		is a foreign key of the table student
    @param university:	is a foreign key of the table university
    @timeArrivedSchool:	in witch time/date they arrived at the school
    @comment:			This table is use to know the destination of the driver and witch time his arrive
*/	
create table destination
(
	id int auto_increment,
	driver smallint not null,
	university char(4) not null,
    timeArrivedSchool date not null,
	primary key(id),
	FOREIGN KEY(university) REFERENCES universities_ctg(id),
	FOREIGN KEY(driver) REFERENCES students(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*ridePassenger documentation

    @param spot:				is a foreign key of the table spot
    @param passenger:			is a foreign key of the table student is the person who take the raite
    @destination:				is a foreign key of the table destination
	@param timeArrivedDriver:	whitch time the driver pass that spots
	@param status:				1 for active, 0 for disable
    @comment:					this is a intermediate table of spot and passenger, this is use to know who passenger request and the time he picket 
								spot
*/
CREATE TABLE IF NOT EXISTS ridePassenger /* table intermedia que llena los autos con los pasajeros */
(
	spot int,
	passenger smallint,
    destination int not null,
	picked_at date not null,
	timeArrivedDriver date not null,
    status bit not null default 1,
	primary key(spot,passenger),
	FOREIGN KEY (passenger) REFERENCES students(id),
    FOREIGN KEY (spot) REFERENCES spots(id),
	FOREIGN KEY (destination) REFERENCES destination(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;


/*reportoption documentation

	@param id:				identifier of the table ridePassenger
    @param description:		is a foreign key of the table spot
    @comment:				this table is a complement of the table report, this give the why of the report
*/
CREATE TABLE IF NOT EXISTS reportOption
(
	id int auto_increment,
	description varchar(100) not null,
	primary key(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*reports documentation

	@param id:				identifier of the table reports
    @param reportoption:	is a foreign key of the table reportoption
    @param dateOfReport:	the date of the student do the report
    @param ride:			is a foreign key of the table ride, the raite of a student use
    @param whoReport:		identifier of the table student, is use to know who reports
    @param status:			1 for active, 0 for disable
    @comment:				this table is use to store the reports of the student sends
*/
CREATE TABLE IF NOT EXISTS reports
(
	id int auto_increment,
	reportoption int not null,
	dateOfReport datetime default NOW() not null,
	ride int not null,
	whoReport smallint not null,
	status bit default 1,
	primary key(id),
	foreign key(reportoption) references reportOption(id),
    foreign key(whoReport) references students(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*timeban documentation

	@param id:				identifier of the table timeban
    @param description:		the date of the ban put in weeks
    @This table is a complement of the table reports to assing the time of the ban
*/
CREATE TABLE IF NOT EXISTS timeban
(
	id int AUTO_INCREMENT,
	description varchar(100) not null,
	primary key(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;

/*Banlist documentation
    
	@param id:			identifier of the table banlist
    @param reportman:	is a foreign key of the table student, this is the student who is report
    @param timeban:		is a foreign key of the table timeban, this is the time of the ban
    @param status:		is a foreign key of the table ride, the raite of a student use
    @comment:			This table is use when the student is report many times and we want to negate tho use or give the service
*/
CREATE TABLE IF NOT EXISTS banlist
(
	id int auto_increment,
	reportman smallint not null,
	timeban int not null,
	status bit not null default 1,
	primary key(id),
	foreign key(reportman) references students(id),
	foreign key(timeban) references timeban(id)
)engine = InnoDB  character set utf8 collate utf8_spanish_ci;
