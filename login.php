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

function compose_invitation_message( $link ) {
    $text = "Kontostatus: 1 von 2 Aktivierungen abgeschlossen<br>Sie koennen nun Ihre Daten erfassen und die Suchfunktion nutzen.<br><br>";
    $text = $text . "Aktuelle Einschraenkungen:<br>- E-Mail-Adressen der Teilnehmer/innen sind nicht sichtbar<br>- Sie koennen Ihr Passwort nicht aendern.<br><br>";
    $text = $text . "Um Ihr Konto vollstaendig zu aktivieren haben Sie zwei Moeglichkeiten:<br><br>";
    $text = $text . "(1) Warten Sie 30 Tage (Ihr Konto wird dann automatisch aktiviert).<br>";
    $text = $text . "(2) Werden Sie selbst aktiv und werben Sie weitere Mitglieder fuer LIPS:<br>";
    $text = $text . "- Versenden Sie den untenstehenden Aktivierungslink an weitere Personen<br>";
    $text = $text . "- Verwenden Sie hierfür eine weitere anonyme E-Mail oder einen anonymen <a href=\"remailer.php\">Remailer.</a><br>";
    $text = $text . "- Sobald sich jemand ueber den versendeten Link registriert, wird Ihr Konto definitiv freigeschaltet.<br><br>";
    $text = $text . "Aktivierungslink (kopieren mit Rechtsklick):<br><br><a class=\"longlink\" href=\"$link\">$link</a><br><br>";
    return $text;
}
 
    include "template_page_beginning.php";
    
    error_reporting(0);
    session_start();
    $_SESSION['timeout'] = time();
    
    require 'validate_input.php';
   
    // read POST-values
    $email = valin($_POST['email']);
    $pword = valin($_POST['pword']);

    // start login
    if ($_SESSION['eingeloggt'] == true) {
        $email = valin($_SESSION['email']);
        die("<p>Sie sind bereits eingeloggt. ($email)</p><p><i>Wenn Sie sich mit einer anderen E-Mail einloggen moechten, muessen Sie sich zuerst ausloggen.</i></p>");
    } else {
        // connect to database
        require 'connect_to_database.php';
        // check if email exists in users
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysql_query($query);
        $num = mysql_numrows($result);
  
        if ($num == 0) {
            die("E-Mail nicht registriert. Sie muessen zuerst eine gueltige E-Mail registrieren, bevor Sie sich anmelden koennen.<br>");
        } else {
            // read salt and calculate user hash with salt + pw
            $i = 0;
            $salt = valin(mysql_result($result,$i,"salt"));
            $salt2 = valin(mysql_result($result,$i,"salt2"));
            $pw_hash = hash( "sha256", $salt . $pword);
            $db_hash = valin(mysql_result($result,$i,"hash"));
            
            // echo "email: $email pword: $pword salt: $salt pw_hash: $pw_hash db_hash: $db_hash<br>";
            
            // password hashes match
            if ($pw_hash === $db_hash) {
                $_SESSION['eingeloggt'] = true;
                $_SESSION['email'] = valin($email);
                // set all other session-variables for faster access
                $_SESSION['land_biete'] = valin(mysql_result($result,$i,"land"));
                $_SESSION['kriterium_ausland'] = mysql_result($result,$i,"auslandtausch");
                $_SESSION['land_suche'] = valin(mysql_result($result,$i,"land_suche"));
                $_SESSION['sim_biete'] = valin(mysql_result($result,$i,"sim_biete"));
                $_SESSION['typ_biete'] = mysql_result($result,$i,"typ_biete");
                $_SESSION['sim_suche'] = valin(mysql_result($result,$i,"sim_suche"));
                $_SESSION['typ_suche'] = mysql_result($result,$i,"typ_suche");
                $_SESSION['post'] = mysql_result($result,$i,"post");
                $_SESSION['treffen'] = mysql_result($result,$i,"treffen");
                $_SESSION['hub'] = mysql_result($result,$i,"hub");
                $_SESSION['party'] = mysql_result($result,$i,"party");
                $_SESSION['phone'] = mysql_result($result,$i,"phone");
                $_SESSION['datum'] = valin(mysql_result($result,$i,"datum"));
                $_SESSION['ort'] = valin(mysql_result($result,$i,"ort"));
                $_SESSION['string_model'] = valin(mysql_result($result,$i,"model"));
                $_SESSION['status'] = mysql_result($result,$i,"status");
                $_SESSION['failed_logins'] = mysql_result($result,$i,"failed_logins");
                // initialize session-variables for search form
                require 'set_session_search_variables.php';
                
                // check if status is still 1 (i.e. entrance code hasn't been validated yet) and can be updated to 2
                if ($_SESSION['status'] == 1) {
                    // calculate entrance hash with salt2 and user password
                    $entrance = hash( "sha256", $salt2 . $pword);
                    $query = "SELECT * FROM entrance WHERE hash='$entrance'";
                    $result= mysql_query($query);
                    if (mysql_numrows($result) > 0) {
                        // check if used > 0 (i.e. has been validated)
                        $used = valin(mysql_result($result,0,"used"));
                        if ($used > 0) {
                            // entrance code has been used => update user status (session-variable AND database)
                            $_SESSION['status'] = 2;
                            $query = "UPDATE users SET status = 2 WHERE email = '$email'";
                            $result= mysql_query($query) or die("Database error.");
                            // delete entrance hash
                            $query = "DELETE FROM entrance WHERE hash = '$entrance'";
                            $result= mysql_query($query) or die("Database error.");
                            // display message to user
                            echo "Glückwunsch - Ihr Status wurde auf 2 (volle Aktivierung) geaendert!<br>Sie koennen LIPS nun uneingeschraenkt nutzen.<br>";
                        } else {
                            // entrance code hasn't been used but hash is older than 30 days (i.e. expiration date has passed)
                            // in this case, the status is updated to 2
                            $expiration = valin(mysql_result($result,0,"expiration"));
                            if (time() - $expiration > 0) {
                                $_SESSION['status'] = 2;
                                $query = "UPDATE users SET status = 2 WHERE email = '$email'";
                                $result= mysql_query($query) or die("Database error.");
                            
                                // delete entrance hash
                                $query = "DELETE FROM entrance WHERE hash = '$entrance'";
                                $result= mysql_query($query) or die("Database error.");
                                // display message to user
                                echo "Glückwunsch - Ihr Status wurde nach 30 Tagen auf 2 (volle Aktivierung) geaendert!<br>Sie koennen LIPS nun uneingeschraenkt nutzen.<br>";
                            } else {
                                $link = "$url_prefix_website_lips/register_with_invitation.php?entrance=$entrance";
                                $back = compose_invitation_message( $link );
                                echo "$back";
                            }
                        }
                    } else {
                        // entrance hash is not yet in entrance table => write it to the table
                        // expiration = actual date + 30 days = + 30 x 24 x 60 x 60 = 2592000
                        $expiration = time() + 2592000;
                        $query = "INSERT INTO entrance VALUES('', '$entrance', 0, $expiration)";
                        $result= mysql_query($query) or die("Schreiben entrance hash nicht moeglich.");
                        
                        $link = "$url_prefix_website_lips/register_with_invitation.php?entrance=$entrance";
                        $back = compose_invitation_message( $link );
                        echo "$back";
                    
                        // send an email at the first login (when expiration hash is written)
                        require_once "common_mailer.php";
                        $subject = "Invitation link";
                        $text = "Please click on the link below to register e-mail addresse:\n\n$link\n\n(if it doesn\'t work, copy the link in your browser window)";
                        send_the_dove( $email, $subject, $text );
                    }
                }
                
                $failed_logins = $_SESSION['failed_logins'];
                echo "Sie sind nun eingeloggt.<br>($failed_logins failed logins.)<br>";
                $failed_logins = 0;
                // set randomized login data = actual date +/- 30 days
                $randomize_date = rand( 0, 5184000) - 2592000;
                $login_date = date('Y-m-d', time() + $randomize_date);
                // echo "login_date: $login_date<br>";
                // write data
                $query = "UPDATE users SET last_activity = '$login_date', failed_logins = $failed_logins WHERE email = '$email'";
                $result= mysql_query($query) or die("Database error.");
                if ($_SESSION['status'] == 1) {
                    /*
                    $text = "Ihr aktueller Status: 1 (E-Mail-Daten nicht sichtbar)<br>";
                    $link = "$url_prefix_website_lips/register_with_invitation.php?entrance=$entrance";
                    $text = $text . "Aktivierungslink: <a href=\"$link\">$link</a><br>";
                    $text = $text . "Senden Sie diesen Link an weitere Personen, um Ihren Account zu aktivieren.<br>";
                    $text = $text . "Verwenden Sie hierfür einen <a href=\"anonymous_remailers.html\">anonymen Remailer</a>.";
                    echo "$text";
                    */
                    // send mail (each time the person logs in?!)
                    /*
                    require_once "common_mailer.php";
                    $subject = "Validation link";
                    $text = "Please click on the link below to register e-mail addresse:\n\n$link\n\n(if it doesn\'t work, copy the link in your browser window)";
                    send_the_dove( $email, $subject, $text );
                    */
                }
            } else {
                $_SESSION['failed_logins'] += 1;
                $failed_logins = $_SESSION['failed_logins'];
                $query = "UPDATE users SET failed_logins = $failed_logins WHERE email = '$email'";
                $result= mysql_query($query) or die("Database error.");
                die("Passwort nicht korrekt.<br>");
            }
        }     
        mysql_close();
    }

    include "template_page_end.php";
    
?>
