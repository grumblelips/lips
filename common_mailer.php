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

// this part of the program contains the mailing function used 
// by different parts of the program

function send_the_dove ( $email, $subject, $text ) {
/*
    echo "Mail function is not very reliable at the moment (find E-Mail facsimile hereafter):<br>";
    echo "<pre>--------------------------------------------------------------------<br>To: $email<br>";
    echo "Subject: $subject<br>";
    echo "Body:<br>$text<br>--------------------------------------------------------------------</pre>";
*/
    // use anonymous-remailer to send mail
    
    # Our new data
	$data = array(
    		'to' => "$email",
    		'subject' => "$subject",
    		'text' => "$text"
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
	echo "Validierungslink versandt. ACHTUNG: Durch die Verwendung eines anonymen Remailers kann es einige Zeit (d.h. Minuten oder Stunden) dauern, bis die Nachricht bei Ihnen eintrifft. Falls Sie auch 12 Stunden spaeter noch kein Mail erhalten haben, wiederholen Sie bitte die Registrierung.<br><br>Sollte das Problem weiterhin bestehen, kontaktieren Sie bitte den Webmaster (grumble_lips@sigaint.org).<br>";


/*

        // send mail via smtp server
        
        require_once "Mail.php";
 
        require 'email_server.php'; // all personal data in email_server.php
	$to = $email;
        $subject = "Validation E-Mail-Address";
        $body = "Please click on the link below to register e-mail addresse:\n\n$link\n\n(if it doesn't work, copy the link in your browser window)";
 
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
            echo("<p>Der Aktivierungslink wurde an die Adresse $email versandt.<br>Sie muessen diesen nun bestaetigen.<br>Loggen Sie sich danach ein und vervollstaendigen Sie Ihre persoenlichen Daten.</p>");
        }
*/
}

?>
