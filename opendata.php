<?php

if(!isset($_GET['id']))die("1");
$idtable = $_GET['id'];
if($idtable!=347854)die();
$nom_table = "lime_survey_".$idtable;
include_once( 'rcp_parameters.php');

mysql_connect("localhost", SQL_USER, SQL_PASSWORD) or die(mysql_error());
mysql_select_db(SQL_DATABASE) or die(mysql_error());

$duid = mysql_real_escape_string($_GET['duid']);                                         
$identifiant = mysql_real_escape_string($_GET['id']);     

$sql= mysql_real_escape_string("SELECT * from $nom_table ORDER BY id DESC limit 0 , 50");
$result = mysql_query( $sql);
//echo $sql;
$typeodeur = array("--", 'Gaz       ','Brul&eacute;  ','Oeuf pourri','Sucr&eacute;      ','Acide/&eacute;touffant','Autre        ',"pas d'odeur   ");
$quand = array("--",'plus de 24 heures',' 24 heures     ', 'une demi-journ&eacutee','2-4 heures      ','quelques minutes','--');
$duree = array("--",'quelques dizaine de minutes','quelques heures      ','une journŽe ou plus','Dure encore maintenant');
while ($row = mysql_fetch_array($result)) { 
      echo "odeur :".$typeodeur[$row['347854X485X1378']];
      echo "   quand :".$quand[$row['347854X486X1379']];
     echo "   duree :".$duree[$row['347854X487X1380']];
     $debut = $row['347854X488X1381'];
     $posalt = strpos($debut,',alt');
      echo "   GPS :".substr($debut,0,$posalt);
      //print_r($row);
      echo "<br>";
    }
  
?>