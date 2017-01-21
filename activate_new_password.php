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
<h1>Aktivierung neues Passwort</h1>
<?php     
    error_reporting(0);
    require 'validate_input.php'; 
    // read GET-data
    $email = valin($_GET['email']);
    $validation = valin($_GET['value1']);
    // connect to database
    require 'connect_to_database.php';
    // check, if email exists in register
    $query = "SELECT * FROM register WHERE email='$email'";
    $result = mysql_query($query) or die("Database error");
    
    if (mysql_numrows($result) > 0) {
        
        $salt = valin(mysql_result($result,0,"salt"));
        $compare = hash( "sha256", $salt . $validation);
        $pw_hash = valin(mysql_result($result,0,"pw_hash"));
        $reg_hash = valin(mysql_result($result,0,"reg_hash"));
        
        // echo "pwh: $pw_hash rh: $reg_hash c: $compare";
        if (($pw_hash === '') or ($reg_hash === '')) {
            die("Link is not valid.");
        }
        if ($compare === $reg_hash) { // Registrierungs-Hashes stimmen ueberein.
    
            echo "<p>Um das Passwort zu aktivieren geben Sie es zur Bestaetigung noch einmal ein:</p><form action=\"set_new_password.php\" method=\"post\">
            <p>E-Mail: <input type=\"textbox\" name=\"email\" value=\"$email\"></p>
            <p>Passwort: <input type=\"password\" name=\"pword\"></p>
            <input type=\"submit\" text=\"click here\">
            </form>";
            
        } else { 
            $query = "UPDATE register SET salt = '', pw_hash = '', reg_hash = '' WHERE email = '$email'";
            $result= mysql_query($query) or die("Database error.");
            die("Link not valid."); 
        }
    } else { 
        $query = "UPDATE register SET salt = '', pw_hash = '', reg_hash = '' WHERE email = '$email'";
        $result= mysql_query($query) or die("Database error.");
        die("Reaktivierung nicht moeglich."); 
    }
    
?>
</body>
</html> 
