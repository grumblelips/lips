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
    $_SESSION['hauptkriterium'] = 0;
    $_SESSION['kriterium_land'] = 0;
    if ($_SESSION['land_suche'] === '') {
        $_SESSION['string_land_suche']=$_SESSION['land_biete'];
    } else {
        $_SESSION['string_land_suche']=$_SESSION['land_suche'];
    }
    $_SESSION['kriterium_sim_biete'] = 0;
    $_SESSION['string_sim_biete']=$_SESSION['sim_suche'];
    if ($_SESSION['typ_suche'] == '') { 
        $_SESSION['int_typ_biete']='1';
    } else {
        $_SESSION['int_typ_biete']=$_SESSION['typ_suche'];
    }
    $_SESSION['kriterium_sim_suche'] = 0;
    $_SESSION['string_sim_suche']=$_SESSION['sim_biete'];
    $_SESSION['int_typ_suche']=$_SESSION['typ_biete'];
    $_SESSION['string_sim_biete']=$_SESSION['sim_suche'];
    if ($_SESSION['typ_biete'] == '') { 
        $_SESSION['int_typ_suche']='1';
    } else {
        $_SESSION['int_typ_suche']=$_SESSION['typ_biete'];
    }
    $_SESSION['kriterium_post'] = 0;
    $_SESSION['kriterium_treffen'] = 0;
    $_SESSION['kriterium_hub'] = 0;
    $_SESSION['kriterium_party'] = 0;
    $_SESSION['kriterium_phone'] = 0;
    // $_SESSION['model'] = $_SESSION['string_model']; 
    $_SESSION['kriterium_ort'] = 0;
    $_SESSION['string_ort'] = $_SESSION['ort'];
?>
