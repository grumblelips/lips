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
<html>
<body>
<?php 
error_reporting(0);
session_start();
require 'handle_session.php';
require 'validate_input.php';
require 'connect_to_database.php';
include "template_page_beginning.php";

if ($_SESSION['status'] < 2) { 
    die("Solange der Account nicht vollstaendig aktiviert ist, koennen Sie Ihr Passwort nicht aendern.");
}

if ($_SESSION['eingeloggt'] == true) { 
    $email = valin($_SESSION['email']);
    $pword1 = valin($_POST['pword1']);
    $pword2 = valin($_POST['pword2']);
    $pword3 = valin($_POST['pword3']);
    if ($pword2 === $pword3) {
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysql_query($query);
        $num = mysql_numrows($result);
        // echo "query = $query";
        
        if ($num == 0) {
            die("E-Mail nicht registriert. Sie muessen zuerst eine gueltige E-Mail registrieren, bevor Sie sich anmelden koennen.<br>");
        } else {
            $i = 0;
            $salt = valin(mysql_result($result,$i,"salt"));
            $pword1_hash = hash( "sha256", $salt . $pword1);
            $pword2_hash = hash( "sha256", $salt . $pword2);
            $db_pw_hash = valin(mysql_result($result,$i,"hash"));
        
            if ($db_pw_hash === $pword1_hash) { // Passwort ist gueltig
                $query = "UPDATE users SET hash = '$pword2_hash' WHERE email = '$email'";
                // echo "Query: $query<br>";
                $result= mysql_query($query) or die("Database error.");
                die("Passwort geaendert.");
            } else {
                die("Passwort ungueltig.");
            }
        }
    } else {
        die("Die neuen Passwoerter stimmen nicht ueberein.");
    }
}
include "template_page_end.php";
?>
