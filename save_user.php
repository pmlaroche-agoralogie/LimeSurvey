<?php
//association between a device id and an arbitrary people id

if(!isset($_GET['id']))die();
include_once( 'rcp_parameters.php');

// in case of problem, log everything !
$filename_log = 'logs/_CHANGETHIS_'.time().'.txt';
file_put_contents($filename_log,$_SERVER['REQUEST_URI']);

mysql_connect("localhost", SQL_USER, SQL_PASSWORD) or die(mysql_error());
mysql_select_db(SQL_DATABASE) or die(mysql_error());

$duid = mysql_real_escape_string($_GET['duid']);                                         
$identifiant = mysql_real_escape_string($_GET['id']);     

$sql= "INSERT INTO `table_device_identifiant` (`id_dev_id`, `deviceid`, `identifiant_libre`, `creation_ts`) VALUES ('', '$duid', '$identifiant', CURRENT_TIMESTAMP)";
mysql_query( $sql);

echo "1";
?>