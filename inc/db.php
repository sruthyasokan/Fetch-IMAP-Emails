<?php 
$servername = "sg2nlmysql11plsk.secureserver.net:3306";
$username = "testdbmailuser";
$password = "el3q8Q_3";
$dbname = "testdbmail";

// Create connection
$dbconn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($dbconn->connect_error) {
  die("Connection failed: " . $dbconn->connect_error);
}

?>