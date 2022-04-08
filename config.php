<?php

$serverName = "DESKTOP-AD8OSTQ"; //serverName\instanceName, portNumber (default is 1433)
$connectionInfo = array( "Database"=>"pms", "UID"=>"sa", "PWD"=>"Bunsoph@16");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

// if( $conn ) {
//      echo "Connection established.<br />";
// }else{
//      echo "Connection could not be established.<br />";
//      die( print_r( sqlsrv_errors(), true));
// }

?>
