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

include "template_page_beginning.php";
    
require 'handle_session.php';
if ($_SESSION['eingeloggt'] != true) {
    die("<h1>Suchen</h1><p>Sie muessen eingeloggt sein, um diese Funktion zu nutzen.</p></body><html>");
    }
?>

<h1>Suchen</h1>
<form action="show_data.php" method="post">
<p>
Bitte waehlen:</p>
<table>
<tr><td><input type="radio" name= "hauptkriterium" value="0"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['hauptkriterium'] == 0) {
        echo " checked";
    }
}
?>

></td><td>alle anzeigen *</td>
</tr>
<tr><td><input type="radio" name= "hauptkriterium" value="1"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['hauptkriterium'] == 1) {
        echo " checked";
    }
}
?> 
></td><td>folgende Kriterien:</td>
</tr>
</table>

<p><b>(1) Benutzer/in:</b></p>
<table>

<tr><td><input type="checkbox" name= "kriterium_land" value="1"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_land']) {
        echo " checked";
    }
}
?>
>Land:</td><td><input type="text" name="land_suche"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $land = $_SESSION['string_land_suche'];
    $addvalue = "value=\"$land\"";
    echo "$addvalue";
}
?>
></td></tr>
<tr><td></td><td></td></tr>
<tr><td>&nbsp;<u>SIM:</u></td><td></td></tr>
<tr><td><input type="checkbox" name= "kriterium_sim_biete" value="1"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_sim_biete']) {
        echo " checked";
    }
}
?>
>Biete:</td><td><input type="text" name="sim_biete"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $sim_biete = $_SESSION['string_sim_biete'];
    $addvalue = "value=\"$sim_biete\"";
    echo "$addvalue";
}
?>
>
<input type="radio" name="typ_biete" value="100"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['int_typ_biete'] == 100) {
    echo " checked";
    }
}
?>

> alle
<input type="radio" name="typ_biete" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['int_typ_biete'] == 1) {
    echo " checked";
    }
}
?>

> mini
<input type="radio" name="typ_biete" value="2"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['int_typ_biete'] == 2) {
    echo " checked";
    }
}
?>

> micro
<input type="radio" name="typ_biete" value="3"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['int_typ_biete'] == 3) {
    echo " checked";
    }
}
?>

> nano</td></tr>
<tr><td><input type="checkbox" name= "kriterium_sim_suche" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_sim_suche'] == 1) {
    echo " checked";
    }
}
?>
>Suche:</td><td><input type="text" name="sim_suche"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $sim_suche = $_SESSION['string_sim_suche'];
    $addvalue = "value=\"$sim_suche\"";
    echo "$addvalue";
}
?>
>
<input type="radio" name="typ_suche" value="100"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['int_typ_suche'] == 100) {
    echo " checked";
    }
}
?>

> alle
<input type="radio" name="typ_suche" value="1"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['int_typ_suche'] == 1) {
    echo " checked";
    }
}
?>

> mini
<input type="radio" name="typ_suche" value="2"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['int_typ_suche'] == 2) {
    echo " checked";
    }
}
?>

> micro
<input type="radio" name="typ_suche" value="3"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['int_typ_suche'] == 3) {
    echo " checked";
    }
}
?>
> nano</td></tr>

</table>

<p><b>(2) Tauschart:</b></p>
<table><tr><td><input type="checkbox" name= "kriterium_post" value="1"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_post']) {
        echo " checked";
    }
}
?>

>Post</td>
</tr><tr><td><input type="checkbox" name= "kriterium_treffen" value="1"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_treffen']) {
        echo " checked";
    }
}
?>

>Treffen</td>
</tr><tr><td><input type="checkbox" name= "kriterium_hub" value="1"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_hub']) {
        echo " checked";
    }
}
?>

>Hub</td>
</tr><tr><td><input type="checkbox" name= "kriterium_party" value="1"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_party']) {
        echo " checked";
    }
}
?>

>Party</td></tr></table>
<p><b>Ergaenzungen:</b></p>
<table>

<tr><td><input type="checkbox" name= "kriterium_ort" value="1"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_ort']) {
        echo " checked";
    }
}
?>

>Ort:</td> 
<td><input type="text" name="ort"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $ort = $_SESSION['string_ort'];
    $addvalue = "value=\"$ort\"";
    echo "$addvalue";
}
?>


></td></tr>

<tr><td><input type="checkbox" name= "kriterium_phone" value="1"

<?php
if ($_SESSION['eingeloggt'] == true) { 
    if ($_SESSION['kriterium_phone']) {
        echo " checked";
    }
}
?>

>Modell:</td>
<td><input type="text" name="model"

<?php 
if ($_SESSION['eingeloggt'] == true) { 
    $model = $_SESSION['string_model'];
    $addvalue = "value=\"$model\"";
    echo "$addvalue";
}
?>


></td></tr>
</table>
<p>* Angegebene Kriterien werden nicht beachtet.</p>
<input type="submit">
</form>


<?php
include "template_page_end.php";
?>    