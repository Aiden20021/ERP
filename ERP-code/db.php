<?php
// Database credentials
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create connection
function getConnection() {
  global $servername, $username, $password, $dbname;
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Removed the extra '1'
  }
  return $conn;
}
?>
