/*			Mysql	*/
/*Host		:Localhost */
/*Database	:sharemycar/database/DDL.sql */

/* comment   :Si se requiere elimimar por alguna razon algun dato, recordar las llaves foraneas*/

/*Fecha de creacion: 13/FEB/2018 */
/*----------------------------------------------------------------------------------------------------------------------------------*/

use sharemycar;

/*----------------------------------------------------------------------------------------------------------------------------------*/

/*delete from states*/
delete from states_ctg where id = 'BCN';
update states_ctg set status = 0 where id = 'BCN';

/*delete from cities*/
delete from cities_ctg where id = 0;
update cities_ctg set status = 0 where id = 1;

/*delete from universities*/
update universities_ctg set status = 0 where id = 'UTT';
delete from universities_ctg where id = 'UTT';

/*delete from student*/
update students set status = 0 where id = 1;
delete from students where id = 1;

/*delete from brand*/
update brands_ctg set status = 0 where id = 1;
delete from brands_ctg where id = 1;

/*delete from model*/
update models_ctg set status = 0 where id = 1;
delete from models_ctg where id = 1;

/*delete from car*/
update cars set status = 0 where id = 1;
delete from cars where id = 1;

/*delete from spot*/
update spots set status = 0 where id = 1;
delete from spots where id = 1;

/*delete from destination*/
delete from destination where id = 1;

/*delete from ridePassenger*/
update ridePassenger set status = 0 where spot = 1 and passenger = 1;
delete from ridepassenger where spot = 1 and passenger = 1; 

/*delete from reportoption*/
delete from reportoption where id = 1;

/*delete from report*/
update reports set status = 0 where id = 1;
delete from reports where id = 1;

/*delete from timeban*/
delete from timeban where id = 1;

/*delete from banlist*/
update banlist set status = 0 where id = 1;
delete from banlist where id = 1;
