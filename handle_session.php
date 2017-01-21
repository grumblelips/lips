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
    if ($_SESSION['eingeloggt'] == true) {
        $duration = 300; // maximum duration of session in seconds
        if ($_SESSION['timeout'] + $duration < time()) {
            // session timed out
            // remove all session variables
            session_unset();
            // destroy the session
            session_destroy();
            include "template_page_beginning.php";
            echo "Sitzung abgelaufen - loggen Sie sich neu ein.";
            include "template_page_end.php";
        } else {
            // session ok
            $_SESSION['timeout'] = time();
        }
    }
    
?>
