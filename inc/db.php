<?php 
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "testdbmail";

// Create connection
$dbconn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($dbconn->connect_error) {
  die("Connection failed: " . $dbconn->connect_error);
}

?>