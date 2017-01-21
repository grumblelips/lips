<?php
/*
    LIPS or Link to Itinerating Prepaid SIM is a website + php-program which
    allows users to anonymously exchange prepaid sim-cards and mobile phones 
    in order to fight against surveillance.
    
    Copyright (c) 2017, grumble (grumble_lips@sigaint.org)
    
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/    
?>
<?php
    require 'connect_to_database.php';
    // execute this php manually once before you start using lips (it creates the 
    // 3 necessary tables in your database 
    // Query zum Anlegen der Table (falls table schon existiert wird keine neue angelegt)
    // table users: enthält alle user-Daten
    $query="CREATE TABLE IF NOT EXISTS users (id int(6) NOT NULL auto_increment, email varchar(40) NOT NULL, salt varchar(40), hash varchar(70) NOT NULL, salt2 varchar(40), land varchar(25) NOT NULL, auslandtausch TINYINT, land_suche varchar(25) NOT NULL, sim_biete varchar(20) NOT NULL, typ_biete TINYINT, sim_suche varchar(20), typ_suche TINYINT, post TINYINT, treffen TINYINT, hub TINYINT, party TINYINT, phone TINYINT, datum DATE NOT NULL, ort varchar(25) NOT NULL, model varchar(20) NOT NULL, status TINYINT, last_activity DATE NOT NULL, failed_logins INT, PRIMARY KEY (id), UNIQUE id (id), KEY id_2 (id))";
    $result= mysql_query($query) or die("Database error creating table");
    // table register: wird nur einmalig für die Registrierung benötigt
    $query="CREATE TABLE IF NOT EXISTS register (id int(6) NOT NULL auto_increment, email varchar(40) NOT NULL, salt varchar(40), pw_hash varchar(70) NOT NULL, reg_hash varchar(70) NOT NULL, PRIMARY KEY (id), UNIQUE id (id), KEY id_2 (id))";
    $result= mysql_query($query) or die("Database error creating table");
    // tables for account activation
    $query="CREATE TABLE IF NOT EXISTS entrance (id int(6) NOT NULL auto_increment, hash varchar(70) NOT NULL, used int(6), expiration int(20), PRIMARY KEY (id), UNIQUE id (id), KEY id_2 (id))";
    $result= mysql_query($query) or die("Database error creating table");
?>
