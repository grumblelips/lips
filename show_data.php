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
<html>
<head>
<style>
table {
    font-family: Helvetica, sans-serif;
    font-size: 12px;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border-top: 1px dotted gray;
    border-bottom: 1px dotted gray;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #ffd7d7;
}
</style>
</head>

<?php
// this is not very beautiful, because <head>-tag is inserted 2x ...
// in addition in case of an error the page finishes without closing open div- and other html-tags ...
include "template_page_beginning.php";
?>

<h1>Suchen</h1>
<?php
    error_reporting(0);
    session_start();
    require 'handle_session.php';
    require 'validate_input.php'; 
    
    // user must have status 2 in order to see all data
    if ($_SESSION['status'] < 2) {
        $hide_emails = true;
    } else {
        $hide_emails = false;
    }

    $sim_typ_human_format = array( '1' => 'mini', '2' => 'micro', '3' => 'nano' );
    $suchkriterien_human_format = array( 0 => '-', 1 => 'ja'); 
    
    if ($_SESSION['eingeloggt'] == true) {
        
        // copy POST-data to session-variables
        $_SESSION['hauptkriterium'] = $_POST['hauptkriterium'];
        $_SESSION['kriterium_land'] = $_POST['kriterium_land'];
        $_SESSION['string_land_suche'] = valin($_POST['land_suche']);
        $_SESSION['kriterium_sim_biete'] = $_POST['kriterium_sim_biete'];
        $_SESSION['string_sim_biete'] = valin($_POST['sim_biete']);
        $_SESSION['int_typ_biete'] = $_POST['typ_biete'];
        $_SESSION['kriterium_sim_suche'] = valin($_POST['kriterium_sim_suche']);
        $_SESSION['string_sim_suche'] = valin($_POST['sim_suche']);
        $_SESSION['int_typ_suche'] = $_POST['typ_suche'];
        $_SESSION['kriterium_post'] = $_POST['kriterium_post'];
        $_SESSION['kriterium_treffen'] = $_POST['kriterium_treffen'];
        $_SESSION['kriterium_hub'] = $_POST['kriterium_hub'];
        $_SESSION['kriterium_party'] = $_POST['kriterium_party'];
        $_SESSION['kriterium_ort'] = $_POST['kriterium_ort'];
        $_SESSION['string_ort'] = valin($_POST['ort']);
        $_SESSION['kriterium_phone'] = $_POST['kriterium_phone'];
        $_SESSION['string_model'] = valin($_POST['model']);

        // connect to database
        require 'connect_to_database.php';            
        // build query
        $query = "SELECT * FROM users";
        $connector_needed = false;
        
        if ($_SESSION['hauptkriterium'] == 1) { 
            $query = "$query WHERE"; 
            $connector_needed = false;   
            // expand query with search criteria
            if ($_SESSION['kriterium_land'] == 1) { 
                // $query = "$query land LIKE '%" . $_SESSION['string_land_suche'] . "%'" . " AND land_suche LIKE '%" . $_SESSION['land_biete'] . "%'";
                // Do not check if the country I'm looking for is also looking for my country
                $query = "$query land LIKE '%" . $_SESSION['string_land_suche'] . "%'"; 
                $connector_needed = true; 
            }
            if ($_SESSION['kriterium_sim_biete'] == 1) {
                if ($connector_needed) { $query = $query . " AND "; }
                $query = "$query sim_biete LIKE '%" . $_SESSION['string_sim_biete'] . "%'"; 
                $connector_needed = true; 
                if ($_SESSION['int_typ_biete'] <> 100) { // don't search for all types, only 1 type of sim
                    if ($connector_needed) { $query = $query . " AND "; }
                    $query = "$query typ_biete = '" . $_SESSION['int_typ_biete'] . "'"; 
                    $connector_needed = true; 
                }
            }
            if ($_SESSION['kriterium_sim_suche'] == 1) {
                if ($connector_needed) { $query = $query . " AND "; }
                $query = "$query sim_suche LIKE '%" . $_SESSION['string_sim_suche'] . "%'"; 
                $connector_needed = true; 
                if ($_SESSION['int_typ_suche'] <> 100) { // don't search for all types, only 1 type of sim
                    if ($connector_needed) { $query = $query . " AND "; }
                    $query = "$query typ_suche = '" . $_SESSION['int_typ_suche'] . "'"; 
                    $connector_needed = true; 
                }
            }
           
            // connect exchange type with OR-operator within ()
            $num_args = 0;
            $query_tauschtyp = "";
            $or_needed = false;
            if ($_SESSION['kriterium_post'] == 1) {
                $num_args++;
                $query_tauschtyp = "post = '" . $_SESSION['kriterium_post'] . "'"; 
                $or_needed = true; 
            }
            if ($_SESSION['kriterium_treffen'] == 1) {
                $num_args++;
                if ($or_needed) { $query_tauschtyp = $query_tauschtyp . " OR "; }
                $query_tauschtyp = "$query_tauschtyp treffen = '" . $_SESSION['kriterium_treffen'] . "'"; 
                $or_needed = true; 
            }
            if ($_SESSION['kriterium_hub'] == 1) {
                $num_args++;
                if ($or_needed) { $query_tauschtyp = $query_tauschtyp . " OR "; }
                $query_tauschtyp = "$query_tauschtyp hub = '" . $_SESSION['kriterium_hub'] . "'"; 
                $or_needed = true; 
            }
            if ($_SESSION['kriterium_party'] == 1) {
                $num_args++;
                if ($or_needed) { $query_tauschtyp = $query_tauschtyp . " OR "; }
                $query_tauschtyp = "$query_tauschtyp party = '" . $_SESSION['kriterium_party'] . "'"; 
                $or_needed = true; 
            }
            if ($_SESSION['kriterium_phone'] == 1) {
                $num_args++;
                if ($or_needed) { $query_tauschtyp = $query_tauschtyp . " OR "; }
                $query_tauschtyp = "$query_tauschtyp phone = '" . $_SESSION['kriterium_phone'] . "'"; 
                $or_needed = true; 
            }
            if ($num_args > 0) { 
                if ($num_args > 1) { $query_tauschtyp = "($query_tauschtyp)"; }
                // echo "CN: $connector_needed";
                if ($connector_needed == false) { $query = "$query $query_tauschtyp"; }
                else { $query = "$query AND $query_tauschtyp"; }
                $connector_needed = true;
            }
            
            // connect search criteria ort with AND-operator
            if ($_SESSION['kriterium_ort'] == 1) {
                if ($connector_needed) { $query = $query . " AND "; }
                $query = "$query ort LIKE '%" . $_SESSION['string_ort'] . "%'"; 
                $connector_needed = true; 
            }
            if ($_SESSION['kriterium_phone'] == 1) {
                if ($connector_needed) { $query = $query . " AND "; }
                $query = "$query model LIKE '%" . $_SESSION['string_model'] . "%'"; 
                $connector_needed = true; 
            }

        }
    
        $result=mysql_query($query) or die("Datenbank-Fehler.");
        $num=mysql_numrows($result);
        mysql_close(); 

        // show data
        echo "<p><b>Gefundene Datensaetze: $num</b></p>";
        echo"<table>
                <tr>
                <th>E-Mail</th>
                <th>Land*</th>
                <th>SIM*</th>
                <th>Post</th>
                <th>Treffen</th>
                <th>Hub</th>
                <th>Party</th>
                <th>Handy</th>
                <th>Datum</th>
                <th>Ort</th>
                <th>Status</th>
                </tr>";
  
        $i=0;
        while ($i < $num) {

            echo "<tr>";
            $email = valin(mysql_result($result,$i,"email"));
            
            if ($hide_emails) {
                $at_position = stripos( $email, "@");
                $email = substr_replace($email, str_pad("*", $at_position-2, "*"), 1, $at_position - 2);
            }
            $land_biete = valin(mysql_result($result,$i,"land"));
            $land_suche = valin(mysql_result($result,$i,"land_suche"));
            $auslandtausch = mysql_result($result,$i,"auslandtausch");
            $sim_suche = valin(mysql_result($result,$i,"sim_suche"));
            $typ_suche = mysql_result($result,$i,"typ_suche");
            $sim_biete = valin(mysql_result($result,$i,"sim_biete"));
            $typ_biete = mysql_result($result,$i,"typ_biete");
            $post = mysql_result($result,$i,"post");
            $treffen = mysql_result($result,$i,"treffen");
            $ort = mysql_result($result,$i,"ort");
            $hub = mysql_result($result,$i,"hub");
            $party = mysql_result($result,$i,"party");
            $datum = valin(mysql_result($result,$i,"datum"));
            $phone = valin(mysql_result($result,$i,"phone"));
            $model = valin(mysql_result($result,$i,"model"));
                
            $email_link="<a href=\"$email\">$email</a>";
            
            // SIM: only show 2 (seperate) entries if different
            $typ_biete_human = $sim_typ_human_format[$typ_biete];
            $typ_suche_human = $sim_typ_human_format[$typ_suche];
            
            $eintrag_sim = "$sim_biete ($typ_biete_human) [$sim_suche ($typ_suche_human)]";
            if (($sim_suche === $sim_biete) and ($typ_suche == $typ_biete)) {
                $eintrag_sim = "$sim_biete ($typ_biete_human)";
            }
            if ($land_suche === $land_biete) {
                $land = $land_biete;
            } else {
                $land = "$land_biete [$land_suche]";
            }
            if ($datum === '0000-00-00') { $datum = ''; } // cosmetics
	    if ($model === '') { $modelinsert = ""; } else { $modelinsert = " ($model)"; } // cosmetics
            
            $echostring = "<td>$email_link</td><td>$land</td><td>$eintrag_sim</td><td>$suchkriterien_human_format[$post]</td><td>$suchkriterien_human_format[$treffen]</td><td>$suchkriterien_human_format[$hub]</td><td>$suchkriterien_human_format[$party]</td><td>$suchkriterien_human_format[$phone]$modelinsert</td><td>$datum</td><td>$ort</td><td>$status</td></tr>";
            echo $echostring;
            
            $i++;
        }
        echo "</table><p>* Falls BIETE von SUCHE verschieden, werden die Infos in eckiger Klammer BIETE [SUCHE] angezeigt.";
    } else {
        die("Sie sind nicht eingeloggt.<br>");
    }
    include "template_page_end.php";
?>    