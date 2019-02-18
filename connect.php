<?php
$host="localhost";  // Host name
$username="admin";  // Mysql username
$password="admin";  // Mysql password
$db_name="cccDB";   // Database name

$conect=mysql_connect($host,$username,$password);
if(! $conect)
{
    die('Connection Failed'.mysql_error());
}

mysql_select_db($db_name,$conect);
?>