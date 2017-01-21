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
    include "template_page_beginning.php";
    error_reporting(0);
    require 'validate_input.php';
    
    // read GET-data
    $email = valin($_GET['email']);
    $validation = valin($_GET['value1']);
    $entrance = valin($_GET['value2']);
    $salt2 = substr(md5(microtime()),rand(0,26),8);
    
    // connect to database
    require 'connect_to_database.php';
    
    // check if address already exists in users
    $query = "SELECT * FROM users WHERE email='$email'";
    $result= mysql_query($query);
    if (mysql_numrows($result) > 0) {
        die("Diese E-Mail-Adresse ($email) wurde bereits registriert ($result).");
    }
        
    // check if address exists in register
    $query = "SELECT * FROM register WHERE email='$email'";
    $result= mysql_query($query);
    if (mysql_numrows($result) > 0) {
        // die("Diese E-Mail-Adresse ($email) wurde bereits registriert ($result).");
        $i=0;
        $salt = valin(mysql_result($result,$i,"salt"));
        $pw_lips_hash = valin(mysql_result($result,$i,"pw_hash"));
        $reg_hash = valin(mysql_result($result,$i,"reg_hash"));
    }
    $compare = hash( "sha256", $salt . $validation);
    // create new (second) salt for entrance hash
    
    // echo "salt: $salt salt2: $salt2 validation: $validation compare: $compare reg_hash: $reg_hash pw_hash: $pw_hash<br>";
    
    
    // value corresponds to hash => link valid => write data
    if ($compare === $reg_hash) { 
    
            // create randomized login date: actual date +/- 30 days
            $randomize_date = rand( 0, 5184000) - 2592000;
            $register_date = date('Y-m-d', time() + $randomize_date);
            // echo "register_date = $register_date";
            // write data into users
            $query = "REPLACE INTO users VALUES ('','$email', '$salt', '$pw_lips_hash', '$salt2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, '$register_date', 0)";
            $result= mysql_query($query) or die("Database error.");
            echo "E-Mail-Adresse $email wurde registriert.<br>Sie koennen sich nun einloggen und Ihre persoenlichen Daten vervollstaendigen.<br>(Hier geht's zur <a href=\"$url_prefix_website_lips/index.php\">Hauptseite</a>)";
            // delete values in register (only leave email)
            $query = "UPDATE register SET salt = '', pw_hash = '', reg_hash = '' WHERE email = '$email'";
            $result= mysql_query($query) or die("Database error.");
            // echo "Aktivierungslink geloescht.<br>";
            
            // validate entrance-table (for user who sent the link)
            $query = "SELECT * FROM entrance WHERE hash='$entrance'";
            $result= mysql_query($query);
            if (mysql_numrows($result) > 0) {
                // increment used to validate user
                $used = valin(mysql_result($result,0,"used")) + 1;
                $query = "UPDATE entrance SET used = '$used' WHERE hash = '$entrance'";
                $result= mysql_query($query) or die("Database error.");
            } else {
                // entrance code does not exist in table => validate a random hash
                // echo "Invalid entrance code.<br>";
                // select hashes that have not yet been validated (i.e. used == 0)
                $query = "SELECT * FROM entrance WHERE used = 0";
                $result= mysql_query($query);
                $i = mysql_numrows($result);
                if ($i > 0) {
                    // choose random user
                    $random_user = rand(0, $i);
                    $used = valin(mysql_result($result, $random_user, "used")) + 1;
                    $entrance = valin(mysql_result($result, $random_user, "hash"));
                    $query = "UPDATE entrance SET used = '$used' WHERE hash = '$entrance'";
                    $result= mysql_query($query) or die("Database error.");
                } // if no unvalidated hashes => don't validate anything
            }
    } else {
        die("This Link ist not valid.");
    }
    include "template_page_end.php";
?>
