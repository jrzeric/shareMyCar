create database if not exists shareMyCar;
use shareMyCar;

/*
drop table if exists historicalRides;
drop table if exists historicalRides_status_ctg;
drop table if exists spotLocations;
drop table if exists users;
drop table if exists cars;
drop table if exists students;
drop table if exists moderators;
drop table if exists profiles_ctg;
drop table if exists models_ctg;
drop table if exists brands_ctg;
drop table if exists universities_ctg;
drop table if exists cities_ctg;
drop table if exists states_ctg;
drop table if exists countries_ctg;
*/

create table if not exists countries_ctg
 (
 	 code char(2),
     name varchar(30) UNIQUE not null,
     PRIMARY KEY (code)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 create table if not EXISTS states_ctg
 (
 	code CHAR(2),
    country CHAR(2) not null,
    name varchar(30) not null,
    PRIMARY KEY (code),
    FOREIGN KEY (country) REFERENCES countries_ctg(CODE)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE table if NOT EXISTS cities_ctg
 (
	CODE smallint AUTO_INCREMENT,
	state char(2) not null,
	name varchar(30) not null,
	PRIMARY KEY (code),
	FOREIGN KEY (state) REFERENCES states_ctg(CODE)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

  create table if NOT EXISTS universities_ctg
 (
 	id tinyint AUTO_INCREMENT,
    city smallint not null REFERENCES cities_ctg(CODE),
    name VARCHAR(60) not null,
    latitude DECIMAL(10, 7) not null,
    longitude DECIMAL(10, 7) not null,
    PRIMARY KEY (id),
    FOREIGN KEY (city) REFERENCES cities_ctg(CODE)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 create table if not EXISTS brands_ctg
 (
 	id tinyint AUTO_INCREMENT,
    name VARCHAR(30) not null,
    PRIMARY KEY (id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE TABLE IF NOT EXISTS models_ctg
 (
 	id tinyint AUTO_INCREMENT,
    brand tinyint,
    name varchar(30) not null,
    PRIMARY KEY (id),
    FOREIGN KEY (brand) REFERENCES brands_ctg(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE TABLE IF NOT EXISTS profiles_ctg
 (
 	code char(1),
    name VARCHAR(10) unique not null,
    PRIMARY KEY (code)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE TABLE IF NOT EXISTS moderators
 (
	id TINYINT AUTO_INCREMENT,
	fullName VARCHAR(60) not null,
	email VARCHAR(60) not null,
	PASSWORD VARCHAR(60) not null,
	status CHAR(2) not null,
	PRIMARY KEY (id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE TABLE IF NOT EXISTS students
 (
	id SMALLINT AUTO_INCREMENT,
	profile CHAR(1) not null,
	surname varchar(30) not null,
	secondSurname varchar(30) not null,
	name varchar(30) not null,
	birthDate date not null,
	email varchar(60) UNIQUE not null,
	cellPhone char(10) UNIQUE not null,
	university tinyint not null,
	controlNumber varchar(15) not null,
	studentId varchar(90) not null,
	payAccount SMALLINT not null,
	latitude varchar(18) not null,
	longitude varchar(18) not null,
	photo varchar(90) DEFAULT '/default.png',
	status CHAR(2) not null,
	created_at TIMESTAMP not null,
	updated_at TIMESTAMP not null,
	validated_at TIMESTAMP,
	validated_by tinyint,
	PRIMARY KEY (id),
	FOREIGN KEY (profile) REFERENCES profiles_ctg(CODE),
	FOREIGN KEY (university) REFERENCES universities_ctg(id),
	FOREIGN KEY (validated_by) REFERENCES moderators(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE TABLE IF NOT EXISTS cars
 (
	driver SMALLINT not null,
	brand TINYINT not null,
	MODEL TINYINT not null,
	year CHAR(4) not null,
	licensePlate CHAR(7) not null,
	driverLicense varchar(90) not null,
	created_at TIMESTAMP,
	updated_at TIMESTAMP,
	validated_by tinyint REFERENCES moderators(id),
	PRIMARY KEY(driver, brand, model),
	FOREIGN KEY (driver) REFERENcES students(id),
	FOREIGN KEY (brand) REFERENCES brands_ctg(id),
	FOREIGN KEY (model) REFERENCES models_ctg(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS users
 (
 	student SMALLINT not null,
    PASSWORD varchar(80) not null,
    PRIMARY KEY (student),
    FOREIGN KEY (student) REFERENCES students(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE TABLE IF NOT EXISTS spotLocations
 (
 	student SMALLINT REFERENCES students(id),
    slot CHAR(1),
    latitude varchar(18),
    longitude varchar(18),
    updated_at TIMESTAMP,
    PRIMARY KEY (student, slot),
    FOREIGN KEY (student) REFERENCES students(id)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE TABLE IF NOT EXISTS historicalRides_status_ctg
 (
 	code CHAR(1),
    status VARCHAR(30),
    PRIMARY KEY (CODE)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

 CREATE TABLE IF NOT EXISTS historicalRides
 (
	id INT PRIMARY KEY AUTO_INCREMENT,
	beginLatitude DECIMAL(10, 7) not null,
	beginLongitude DECIMAL(10,7) not null,
	endLatitude DECIMAL(10, 7) not null,
	endLongitude DECIMAL(10,7) not null,
	driver SMALLINT REFERENCES students(id),
	passenger SMALLINT REFERENCES students(id),
	paymentAmount DECIMAL(5,2),
	requested_at DATETIME,
	mettint_at DATETIME,
	pickedUp_at DATETIME,
	arrived_at DATETIME,
	status CHAR(1)
 )engine = InnoDB  character set utf8 collate utf8_spanish_ci;

ALTER TABLE historicalRides ADD FOREIGN KEY (STATUS) REFERENCES historicalRides_status_ctg(code);
ALTER TABLE historicalRides ADD FOREIGN KEY (driver) REFERENCES students(id);
ALTER TABLE historicalRides ADD FOREIGN KEY (passenger) REFERENCES students(id);
