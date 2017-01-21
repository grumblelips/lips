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
session_start();
require 'handle_session.php';
if ($_SESSION['eingeloggt'] != true) {
    die("<h1>Daten</h1><p>Sie muessen eingeloggt sein, um diese Funktion zu nutzen.</p></body></html>");
    }
?>
<h1>Daten</h1>
<p>Eingabe und Anpassung der Daten.</p>
<form action="enter_data.php" method="post" target="content">
<p><b>(1) Benutzer/in:</b>
<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $email = $_SESSION['email'];
    $addvalue = " $email";
    echo "<FONT COLOR=\"0000FF\"><b>$addvalue</b></FONT>";
    $status = $_SESSION['status'];
    echo " (Status: <a href=\"status_explained.php\">$status</a>)";
}
?>
</p>
<table><tr><td>Land:</td>
<td><input type="text" name="land_biete"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $land = $_SESSION['land_biete'];
    $addvalue = "value=\"$land\"";
    echo "$addvalue";
}
?>
></td>
<td><input type="checkbox" name="kriterium_ausland" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_ausland']) {
        echo " checked";
    }
}
?>
> Auslandtausch: <input type="text" name="ausland_suche"
<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $land_suche = $_SESSION['land_suche'];
    if ($_SESSION['kriterium_ausland']) {
        $addvalue = "value=\"$land_suche\"";
        echo "$addvalue";
    }
}
?>

></td>
</tr>
<tr><td></td><td></td><td></td></tr>
<tr><td><u>SIM:</u></td><td></td><td></td></tr>
<tr><td>Biete:</td>
<td><input type="text" name="sim_biete"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $sim_biete = $_SESSION['sim_biete'];
    $addvalue = "value=\"$sim_biete\"";
    echo "$addvalue";
}
?>
></td>
<td><input type="radio" name="typ_biete" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['typ_biete'] == 1) {
    echo " checked";
    }
}
?>

> mini
<input type="radio" name="typ_biete" value="2"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['typ_biete'] == 2) {
    echo " checked";
    }
}
?>

> micro
<input type="radio" name="typ_biete" value="3"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['typ_biete'] == 3) {
    echo " checked";
    }
}
?>

> nano</td>
</tr><tr><td>Suche:</td>
<td><input type="text" name="sim_suche"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $sim_suche = $_SESSION['sim_suche'];
    $addvalue = "value=\"$sim_suche\"";
    echo "$addvalue";
}
?>
></td>

<td><input type="radio" name="typ_suche" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['typ_suche'] == 1) {
    echo " checked";
    }
}
?>

> mini
<input type="radio" name="typ_suche" value="2"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['typ_suche'] == 2) {
    echo " checked";
    }
}
?>

> micro
<input type="radio" name="typ_suche" value="3"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['typ_suche'] == 3) {
    echo " checked";
    }
}
?>
> nano</td></tr>
</table>

<p><b>(2) Tausch:</b></p>
<table><tr><td>Post:</td> 
<td><input type="radio" name="post" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['post'] == 1) {
    echo " checked";
    }
}
?>

> ja</td>
<td><input type="radio" name="post" value="0"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['post'] == 0) {
    echo " checked";
    }
}
?>

> nein</td>
</tr><tr><td>Treffen:</td>
<td><input type="radio" name="treffen" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['treffen'] == 1) {
    echo " checked";
    }
}
?>

> ja</td>
<td><input type="radio" name="treffen" value="0"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['treffen'] == 0) {
    echo " checked";
    }   
}
?>

> nein</td>
</tr><tr><td>
Hub:</td>
<td><input type="radio" name="hub" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['hub'] == 1) {
    echo " checked";
    }
}
?>

> ja</td>
<td><input type="radio" name="hub" value="0"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['hub'] == 0) {
    echo " checked";
    }   
}
?>


> nein</td>

</tr><tr><td>Party:</td>
<td><input type="radio" name="party" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['party'] == 1) {
    echo " checked";
    }
}
?>

> ja</td>
<td><input type="radio" name="party" value="0"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['party'] == 0) {
    echo " checked";
    }   
}
?>

> nein</td>
</tr><tr><td>Handy:</td>
<td><input type="radio" name="phone" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['phone'] == 1) {
    echo " checked";
    }
}
?>

> ja</td>
<td><input type="radio" name="phone" value="0"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['phone'] == 0) {
    echo " checked";
    }   
}
?>

> nein</td>
</tr></table>

<p><b>Ergaenzungen:</b></p>

<table><tr><td>
Ort:</td> 
<td><input type="text" name="ort"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $ort = $_SESSION['ort'];
    $addvalue = "value=\"$ort\"";
    echo "$addvalue";
}
?>

></td></tr>
<tr><td>Datum:</td> 
<td><input type="text" name="datum"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $datum = $_SESSION['datum'];
    if ($datum === '0000-00-00') { $datum = ''; }
    $addvalue = "value=\"$datum\"";
    echo "$addvalue";
}
?>
> (YYYY-MM-DD)</td>

</tr><tr><td>Modell:</td>
<td><input type="text" name="model"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $model = $_SESSION['model'];
    $addvalue = "value=\"$model\"";
    echo "$addvalue";
}
?>
></td>
</tr></table>

<p>Mit der Teilnahme an der Tauschboerse, akzeptiere ich die allgemeinen Regeln:<br>
- Die getauschte SIM-Karte ist funktionsfaehig und auf meinen Namen registriert.<br>
- Ich werde die getauschte SIM-Karte nicht sperren, es sei denn damit werden nachweislich illegale Aktivitaeten begangen.<br>
- Ich werde die SIM-Karte, die ich erhalten, nicht zu illegalen Zwecken nutzen.<br>
- Ich respektiere die Anonymitaet der anderen Nutzer/innen und werde persoenliche Daten vertraulich behandeln.</p>
<p>PW: <input type="password" name="pword"><input type="submit"></p>
</form>

<?php
    include "template_page_end.php";
?>    