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
    // set variables
    $email = valin($_POST['email']);
    $pw_lips = valin($_POST['pw_lips']);
    $pw_lips_confirm = valin($_POST['pw_lips_confirm']);
    
    // pw must be identical
    if ($pw_lips === $pw_lips_confirm) {
        // create new salt for new pw
        $salt = substr(md5(microtime()),rand(0,26),8);
        $pw_lips_hash = hash( "sha256", $salt . $_POST['pw_lips'] );
        // create new registration hash 
        $validation_value = substr(md5(microtime()),rand(0,26),8);
        $reg_hash = hash( "sha256", $salt . $validation_value);
        
        require 'restrict_mailservices.php';
        require 'connect_to_database.php';
    
        // check if email exists in users and pw matches
        $query = "SELECT * FROM users WHERE email='$email'";
        $result= mysql_query($query);
        if (mysql_numrows($result) > 0) {
            // email is registered => new password activation possible
            $status = valin(mysql_result($result,$i,"status"));
            if ($status < 2) {
                die("Solange Ihr Account nicht vollstaendig aktiviert ist, koennen Sie kein neues Passwort anfordern.");
            }
        
            // write values to register
            $query = "SELECT * FROM register WHERE email='$email'";
            $result= mysql_query($query);
            if (mysql_numrows($result) > 0) {
                $query = "UPDATE register SET salt = '$salt', pw_hash = '$pw_lips_hash', reg_hash = '$reg_hash' WHERE email = '$email'"; 
            } else {
                $query = "INSERT INTO register VALUES('', '$email', '$salt', '$pw_lips_hash', '$reg_hash')";
            }
            $result= mysql_query($query) or die("Schreiben der Registrierungsdaten nicht moeglich.");
            
            // send mail
            $link = "http://$url_prefix_website_lips/activate_new_password.php?email=$email&value1=$validation_value";
            
            require_once "common_mailer.php";
            $subject = "Reactivation link";
            $text = "Please click on the link below to reactivate your e-mail addresse:\n\n$link\n\n(if it doesn\'t work, copy the link in your browser window)\n\nIf you did not request a new password, do NOT click on this link and delete this mail.";
            send_the_dove( $email, $subject, $text );
            
            
/* don't send it in clearnet --- damn fucking bullshit ... !!!

            # send reactivation link
            $data = array(
                'to' => "$email",
                'subject' => "Reactivation link",
                'text' => "Please click on the link below to reactivate your e-mail addresse:\n\n$link\n\n(if it doesn\'t work, copy the link in your browser window)\n\nIf you did not request a new password, do NOT click on this link and delete this mail."
            );
	
            # Create a connection
            $url = 'anonymouse.org/cgi-bin/anon-email_de.cgi';
            $ch = curl_init($url);
            # Form data string
            $postString = http_build_query($data, '', '&');
            # Setting our options
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            # Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            echo "Der Aktivierungslink wurde an die Adresse $email versandt. ACHTUNG: Durch die Verwendung eines anonymen Remailers kann es einige Minuten dauern, bis die Nachricht bei Ihnen eintrifft. Falls Sie auch 12 Stunden spaeter noch kein Mail erhalten haben, wiederholen Sie bitte die Reaktivierung.";
*/
 /*           require_once "Mail.php";
 
            require 'email_server.php'; // all personal data in email_server.php
	    $to = $email;
            $subject = "New password - validation link";
            $body = "You have requested a new password, click on the link below to activate it:\n\n$link\n\nNOTE: If you didn't request a new password delete this e-mail and login with your usual password.";
 
            $headers = array ('From' => $from,
                'To' => $to,
                'Subject' => $subject);
                $smtp = Mail::factory('smtp',
                array ('host' => $host,
                'auth' => true,
                'username' => $username,
                'password' => $password));
 
            $mail = $smtp->send($to, $headers, $body);
 
            if (PEAR::isError($mail)) {
                echo("<p>" . $mail->getMessage() . "</p>");
            } else {
                echo("<p>Der Aktivierungslink wurde an die Adresse $email versandt.<br>Sie muessen diesen nun bestaetigen.</p>");
            }

*/
        } else {
            die("Reaktivierung der Adresse $email nicht moeglich.");
        }
    } else {
        die("Die eingegeben Passwoerter stimmen nicht ueberein.");
    }   
include "template_page_end.php";
?>