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
<?php session_start(); 
include "template_page_beginning.php";
?>
<h1>Anmelden</h1>
<p><b>Registrieren Sie sich mit einer gueltigen E-Mail-Adresse:</b></p>
<form action="send_validation_link.php" method="post">
<p>E-Mail: <input type="text" name="email" size="40"></p>
<p><b>Waehlen Sie ein Password:</b></p>
<p>PW: <input type="password" name="pw_lips" size="20"></p>
<p>PW: <input type="password" name="pw_lips_confirm" size="20"> (wiederholen)</p>
<p><b>Bestaetigen Sie das Captcha:</b></p>
<p><img src="./phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br>
<input type="text" name="captcha_code" size="15"></p>
<p>(Falls das Captcha nicht lesbar ist, clicken Sie auf den Refresh-Button des Browsers, um ein neues zu laden.)</p>
<p><b><i>Sie erhalten auf die angegebene E-Mail-Adresse einen Aktivierungslink, den Sie bestaetigen muessen.</i><b></p>
<input type="submit" text="Abschicken">
</form>
<?php
include "template_page_end.php";
?>