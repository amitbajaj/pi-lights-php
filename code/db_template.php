<?php
//Rename this file to db.php and change the below connection parameters according the environment
$server='MySqlHost';
$dbuser='MySqlLoginID';
$dbpass='MySQLPassword';
$dbname='MySQLDBName';
$conn = new mysqli($server, $dbuser, $dbpass, $dbname);
$isconnected=true;
if ($conn->connect_error) {
    $isconnected=false;
}
?>