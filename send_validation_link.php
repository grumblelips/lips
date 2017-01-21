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
    session_start();
    error_reporting(0);
    
    include "template_page_beginning.php";
    require 'validate_input.php'; 
    
    // set variables
    $email = valin($_POST['email']);
    $pw_lips = valin($_POST['pw_lips']);
    $pw_lips_confirm = valin($_POST['pw_lips_confirm']);
    
	// check captcha
    if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
        // Captcha verification is incorrect.		
        die("Invalid captcha.");
    } else {
        // Captcha verification is correct.	
        // echo "Captcha correct.<br>";
    }

    if ($pw_lips === $pw_lips_confirm) {
        
        $salt = substr(md5(microtime()),rand(0,26),8);
        $pw_lips_hash = hash( "sha256", $salt . $_POST['pw_lips'] );
        $validation_value = substr(md5(microtime()),rand(0,26),8);
        $reg_hash = hash( "sha256", $salt . $validation_value);
        $entrance = $_SESSION['entrance_hash'];
        if ($entrance == "") { $entrance = "0"; } // avoid empty entrance hash
        
        require 'restrict_mailservices.php';
        require 'connect_to_database.php';
  
        // check if email exists and pw match
        $query = "SELECT * FROM users WHERE email='$email'";
        $result= mysql_query($query);
        if (mysql_numrows($result) > 0) {
            die("Diese E-Mail-Adresse ($email) wurde bereits registriert.");
        }

        // write values to register
        $query = "SELECT * FROM register WHERE email='$email'";
        $result= mysql_query($query);
        if (mysql_numrows($result) > 0) {
            // email already registered
            $query = "UPDATE register SET salt = '$salt', pw_hash = '$pw_lips_hash', reg_hash = '$reg_hash' WHERE email = '$email'"; 
        } else {
            $query = "INSERT INTO register VALUES('', '$email', '$salt', '$pw_lips_hash', '$reg_hash')";
        }
        $result= mysql_query($query) or die("Schreiben der Registrierungsdaten nicht moeglich.");
    
        // send mail
        $link = "$url_prefix_website_lips/validate_email.php?email=$email&value1=$validation_value&value2=$entrance";
    
        require_once "common_mailer.php";
        $subject = "Validation link";
        $text = "Please click on the link below to register e-mail addresse:\n\n$link\n\n(if it doesn\'t work, copy the link in your browser window)";
        send_the_dove( $email, $subject, $text );
        
        

    } else {
        die("Die eingegeben Passwoerter stimmen nicht ueberein.");
    }
    include "template_page_end.php";
?>


