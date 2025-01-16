<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erp_systeem";

// Create connection
function getConnection() {
  global $servername, $username, $password, $dbname;
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: 1" . $conn->connect_error);
  }
  return $conn;
}