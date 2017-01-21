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
    // read GET-data
    $email = $_POST['email'];
    $validation = $_POST['pword'];

    // connect to database & check if user exists
    require 'connect_to_database.php';
    $query = "SELECT * FROM register WHERE email='$email'";
    $result= mysql_query($query);
    
    if (mysql_numrows($result) > 0) {
        // user is registerd
        $i = 0;
        $salt = valin(mysql_result($result,$i,"salt"));
        $compare = hash( "sha256", $salt . $validation);
        $pw_hash = mysql_result($result,$i,"pw_hash");
        
        if ($compare === $pw_hash) {  
            // validation is correct => write data
            $query = "UPDATE users SET salt = '$salt', hash = '$pw_hash' WHERE email = '$email'";
            $result= mysql_query($query) or die("Database error.");
            echo "Neues Passwort wurde aktiviert.<br>Sie koennen sich nun damit einloggen.<br>";
            $query = "UPDATE register SET salt = '', pw_hash = '', reg_hash = '' WHERE email = '$email'";
            $result= mysql_query($query) or die("Database error.");
        } else {
            $query = "UPDATE register SET salt = '', pw_hash = '', reg_hash = '' WHERE email = '$email'";
            $result= mysql_query($query) or die("Database error.");
            die("Passwort ungueltig.");
        }
    }
        
?>
