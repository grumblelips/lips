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
	error_reporting(0);
    // using this file to define global variables
    $url_prefix_website_lips = "http://s5jlqdxrcsd77meu.onion";
    
	// connect to database 
	$user="youruserhere";
	$password="yourpwhere";
	$database="yourdbhere";
	$mysql_server="localhost";
	
	mysql_connect($mysql_server,$user,$password);
	@mysql_select_db($database) or die( "Unable to select database");
    
    $query = "SET NAMES 'utf8'";
    $result= mysql_query($query) or die("Database error.");
?>
