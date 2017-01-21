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
    // session_set_cookie_param(1800); // does not work any more: why?
    // cookie expires after half an hour
    // session expires after xx seconds of inactivity (defined in handle_session.php)
    session_start();
    error_reporting(0);
    // session_set_cookie_param(1800); 
    // cookie expires after half an hour
    // session expires after xx seconds of inactivity (defined in handle_session.php)
    require 'handle_session.php';
    $temp = $_SESSION['eingeloggt'];

    // include html-template
    include "template_page_beginning.php";

    // add form to template
    echo "<h1>Login</h1>
    <form action=\"login.php\" method=\"post\">
    <p>E-Mail: <input type=\"text\" name=\"email\"></p>
    <p>PW: <input type=\"password\" name=\"pword\"></p>
    <input type=\"submit\" text=\"click here\">
    </form>";

    // check if user is already logged in
    if ($_SESSION['eingeloggt'] == true) { 
        $email = $_SESSION['email'];
        echo "<p>Sie sind bereits eingeloggt. ($email)</p><p>Wenn Sie sich mit einer anderen E-Mail einloggen  moechten, muessen Sie sich zuerst ausloggen.</p>"; 
    } 

    // finish with hmtl-template
    include "template_page_end.php";
?>
