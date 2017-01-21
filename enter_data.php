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
    require 'validate_input.php';
    
    // read POST-variables
    $email = valin($_SESSION['email']);
    $land_biete = valin($_POST['land_biete']);
    $kriterium_ausland = $_POST['kriterium_ausland'];
    $land_suche = valin($_POST['ausland_suche']);
    $sim_suche = valin($_POST['sim_suche']);
    $typ_suche = $_POST['typ_suche'];
    $sim_biete = valin($_POST['sim_biete']);
    $typ_biete = $_POST['typ_biete'];
    $post = $_POST['post'];
    $treffen = $_POST['treffen'];
    $party= $_POST['party'];
    $hub = $_POST['hub'];
    $phone = $_POST['phone'];
    $ort = valin($_POST['ort']);
    $datum = valin($_POST['datum']);
    $model = valin($_POST['model']);
    $pword = $_POST['pword'];
    
    // connect to database
    require 'connect_to_database.php';
    
    // check if email exists in users 
    $query = "SELECT * FROM users WHERE email='$email'";
    $result= mysql_query($query);
    $num=mysql_numrows($result);
    if ($num == 0) {
        die("E-Mail nicht registriert. Sie muessen zuerst eine gueltige E-Mail registrieren, bevor Sie LIPS verwenden koennen.");
    } else {
        $i = 0;
        $salt = mysql_result($result,$i,"salt");
        $pw_hash = hash( "sha256", $salt . $pword);
    
        // read from database
        $db_email = valin(mysql_result($result,$i,"email"));
        $db_hash = valin(mysql_result($result,$i,"hash"));
        $db_land = valin(mysql_result($result,$i,"land"));
        $db_kriterium_ausland = mysql_result($result,$i,"auslandtausch");
        $db_land_suche = valin(mysql_result($result,$i,"land_suche"));
        $db_sim_suche = valin(mysql_result($result,$i,"sim_suche"));
        $db_typ_suche = mysql_result($result,$i,"typ_suche");
        $db_sim_biete = valin(mysql_result($result,$i,"sim_biete"));
        $db_typ_biete = mysql_result($result,$i,"typ_biete");
        $db_post = mysql_result($result,$i,"post");
        $db_treffen = mysql_result($result,$i,"treffen");
        $db_ort = mysql_result($result,$i,"ort");
        $db_hub = mysql_result($result,$i,"hub");
        $db_party = mysql_result($result,$i,"party");
        $db_phone = mysql_result($result,$i,"phone");
        $db_datum = valin(mysql_result($result,$i,"datum"));
        $db_model = valin(mysql_result($result,$i,"model"));
        $db_status = valin(mysql_result($result,$i,"status"));

        // user is logged in and password matches
        if (($_SESSION['eingeloggt'] == true) && ($pw_hash === $db_hash)) {  
        
            // write only values != '' (otherwise use database entry)
            if ($land === "") { $land = $db_land; }
            if ($provider === "") { $provider = $db_provider; }
            if ($tauschtyp1 === "") { $tauschtyp1 = $db_post; }    // funktioniert nicht: why?
            if ($tauschtyp2 === "") { $tauschtyp2 = $db_treffen; }  // funktioniert nicht: why?
            if ($ort === "") { $orte = $db_ort; }
        
            // also update session variables
            $_SESSION['land_biete'] = $land_biete;
            $_SESSION['kriterium_ausland'] = $kriterium_ausland;
            $_SESSION['land_suche'] = $land_suche;
            $_SESSION['sim_biete'] = $sim_biete;
            $_SESSION['typ_biete'] = $typ_biete;
            $_SESSION['sim_suche'] = $sim_suche;
            $_SESSION['typ_suche'] = $typ_suche;
            $_SESSION['post'] = $post;
            $_SESSION['treffen'] = $treffen;
            $_SESSION['hub'] = $hub;
            $_SESSION['party'] = $party;
            $_SESSION['phone'] = $phone;
            $_SESSION['datum'] = $datum;
            $_SESSION['ort'] = $ort;
            $_SESSION['model'] = $model;
            $_SESSION['status'] = $db_status;
            if ($kriterium_ausland == 0) { $land_suche = $land_biete; }
        
            // set session variables for search function
            require 'set_session_search_variables.php';
    
            // query for writing data into database
            $query = "UPDATE users SET land = '$land_biete', auslandtausch = '$kriterium_ausland', land_suche = '$land_suche', sim_biete = '$sim_biete', typ_biete = '$typ_biete', sim_suche = '$sim_suche', typ_suche = '$typ_suche', post = '$post', treffen = '$treffen', hub = '$hub', party = '$party', phone = '$phone', ort = '$ort', datum = '$datum', model = '$model' WHERE email = '$email'";
            $result= mysql_query($query) or die("Es ist ein Fehler aufgetreten.");
            echo "Daten wurden aktualisiert.<br>";
            
        } else {
            die("Authentifizierung fehlgeschlagen.");
        }
    mysql_close();
    }
    include "template_page_end.php";
    
?>
