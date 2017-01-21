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
?>
<h1>Neues PW</h1>
<?php
    error_reporting(0);
    session_start();
    if ($_SESSION['eingeloggt'] == true) {
        require 'handle_session.php';
        echo "Sie muessen sich zuerst ausloggen, um ein neues Passwort anzufordern.";
        if ($_SESSION['status'] < 2) {
            echo "<br><br>Solange Ihr Account nicht vollstaendig aktiviert ist, koennen Sie kein neues Passwort anfordern.";
        }
    } else {
        echo "<p><b>Verwenden Sie diese Seite, wenn Sie Ihr Passwort vergessen haben:</b></p>
            <form action=\"send_password_reactivation_link.php\" method=\"post\">
            <p>E-Mail: <input type=\"text\" name=\"email\" size=\"40\"></p>
            <p><b>Waehlen Sie ein NEUES Password:</b></p>
            <p>PW: <input type=\"password\" name=\"pw_lips\" size=\"20\"></p>
            <p>PW: <input type=\"password\" name=\"pw_lips_confirm\" size=\"20\"> (wiederholen)</p>
            <p><i>Sie erhalten auf die angegebene E-Mail-Adresse einen Aktivierungslink, den Sie bestaetigen muessen.</i></p>
            <input type=\"submit\" text=\"Abschicken\">
            </form>";
    }
include "template_page_end.php";
?>
