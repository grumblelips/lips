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
    session_start();
    include "template_page_beginning.php";
    
    if ($_SESSION['eingeloggt'] == true) {
        // connect to database
        require 'connect_to_database.php';
        require 'validate_input.php';
        // set variables
        $email = valin($_SESSION['email']);
        $pword = valin($_POST['pword']);
   
        // read data from database
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysql_query($query);
        $num = mysql_numrows($result);
        
        if ($num == 0) {
            die("E-Mail nicht registriert. Sie muessen zuerst eine gueltige E-Mail registrieren, bevor Sie sich anmelden koennen.<br>");
        } else {
            $i = 0;
            $salt = mysql_result($result,$i,"salt");
            $pw_hash = hash( "sha256", $salt . $pword);
            $db_hash = valin(mysql_result($result,$i,"hash"));
            
            // pw is correct
            if ($pw_hash === $db_hash) { 
                // delete user
                $query = "DELETE FROM users WHERE email='$email'";
                $result= mysql_query($query);
                mysql_close();
                session_unset();
                session_destroy();
                echo "Sie wurden ausgeloggt.";
        
                if ($result) {
                    echo "Der Account $email wurde geloescht.";
                } else {
                    echo "Es ist ein Fehler aufgetreten.";
                }
            } else {
                echo "Passwort nicht korrekt.";
            }
        }
    }
    include "template_page_end.php";
?>
