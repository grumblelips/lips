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
session_start();
require 'handle_session.php';
include "template_page_beginning.php";
?>
<h1>Passwort</h1>
<form action="change_password_execute.php" method="post">

<?php 
require 'validate_input.php';
if ($_SESSION['eingeloggt'] == true) { 
    $email = valin($_SESSION['email']);
} else { 
    die("Sie muessen eingeloggt sein, um das Passwort zu aendern.");
}
?>

<p>E-Mail: 
<?php 
  echo " $email";
?>

</p>
<p>PW (alt): <input type="password" name="pword1"></p>
<p>PW (neu): <input type="password" name="pword2"></p>
<p>PW (neu): <input type="password" name="pword3"> (wiederholen)</p>
<input type="submit" text="click here">
</form>
<?php
include "template_page_end.php";
?>
