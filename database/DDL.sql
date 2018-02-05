drop database if exists sharemycar;
create database if not exists sharemycar;
use sharemycar;


create table if not EXISTS states_ctg
 (
 	code CHAR(2),
    name varchar(30) not null,
    PRIMARY KEY (code),
    status bit default 1
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 create table if NOT EXISTS cities_ctg
 (
	code smallint AUTO_INCREMENT,
	state char(2) not null,
	name varchar(30) not null,
    status bit default 1,
	PRIMARY KEY (code),
	FOREIGN KEY (state) REFERENCES states_ctg(CODE)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

  create table if NOT EXISTS location_ctg
 (
 	id int AUTO_INCREMENT,
    latitude DECIMAL(10, 7) not null,
    longitude DECIMAL(10, 7) not null,
    status bit default 1,
    PRIMARY KEY (id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

  create table if NOT EXISTS universities_ctg
 (
 	id tinyint AUTO_INCREMENT,
	name VARCHAR(60) not null,
	city smallint not null REFERENCES cities_ctg(CODE),
    location int,
    status bit default 1,
    PRIMARY KEY (id),
    FOREIGN KEY (location) REFERENCES location_ctg(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

  CREATE TABLE IF NOT EXISTS profiles_ctg
 (
 	code char(1),
    name VARCHAR(10) unique not null,
    PRIMARY KEY (code)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE TABLE IF NOT EXISTS students
 (
	id SMALLINT AUTO_INCREMENT,
	profile CHAR(1) not null,
	surname varchar(30) not null,
	secondSurname varchar(30) not null,
	name varchar(30) not null,
	email varchar(60) UNIQUE not null,
	cellPhone char(13) UNIQUE not null,
	university tinyint not null,
	controlNumber varchar(15) not null,
	studentId varchar(90) not null,
    licenceNumber varchar(12) not null,
    location int not null,
	photo varchar(90) DEFAULT 'img/default.png',
	city smallint not null,
    turn bit default 0, /* 0 for matutino 1 for vespertino*/
	status bit default 1 not null,
	PRIMARY KEY (id),
	FOREIGN KEY (profile) REFERENCES profiles_ctg(CODE),
	FOREIGN KEY (university) REFERENCES universities_ctg(id),
    FOREIGN KEY (location) REFERENCES location_ctg(id),
	FOREIGN KEY (city) REFERENCES cities_ctg(CODE)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 /*Model Cars-------------------------------------------------------------------------------------------------------*/

 create table if not EXISTS brands_ctg
 (
 	id tinyint AUTO_INCREMENT,
    name VARCHAR(30) not null,
    image varchar(60) not null,
    status bit default 1,
    PRIMARY KEY (id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

  CREATE TABLE IF NOT EXISTS models_ctg
 (
 	id tinyint AUTO_INCREMENT,
    brand tinyint,
    name varchar(30) not null,
    status bit default 1,
    PRIMARY KEY (id),
    FOREIGN KEY (brand) REFERENCES brands_ctg(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;
 
 
 CREATE TABLE IF NOT EXISTS spots/* point where the driver going on*/
 (
	id int,
	driver SMALLINT not null,
    location int not null,
    pay decimal,
    timeArrived time not null,
	status bit,
	primary key(id),
	FOREIGN KEY (driver) REFERENCES students(id),
	FOREIGN KEY (location) REFERENCES location_ctg(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS ride /*ride of the passenger/driver*/
 (
	id int,
    spot int not null,
    timeArrived time not null,/* time where the driver arrived at the spot*/
    locationend int not null default 1,
    timeArrivedSchool time not null, /* time where the driver arrived at the school*/
    spaceCar int not null,
    groupPassenger int, /*this give the information about how many student take the ride*/
    status bit
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;
 
 CREATE TABLE IF NOT EXISTS ridePassenger /* table intermedia que llena los autos con los pasajeros */
 (
	ride int not null,
    passenger int not null,
    request_at time,
    picked_at time,
    primary key(ride,passenger),
	FOREIGN KEY (ride) REFERENCES ride(id),
    FOREIGN KEY (passenger) REFERENCES students(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS reportOption
 (
	id int,
    description varchar(100) not null,
    primary key(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS report
 (
	id int,
    reportoption int not null,
    dateOfReport datetime not null,
    ride int not null,
    whoReport char(1)not null,/* the id of the perfil*/
    status bit not null,
    primary key(id),
    foreign key(reportoption) references reportOption(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS timeban
 (
	id int,
    description varchar(100) not null
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;
 
 CREATE TABLE IF NOT EXISTS banlist
 (
	id int,
    report int not null,
    dateofban datetime not null,
    status bit not null
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

