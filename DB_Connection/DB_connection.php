<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "techjobhub";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  // Connection failed
  die("Connection failed: " . mysqli_connect_error());
} else {
  // Connection successful
//   echo "Connected successfully to the database: " . $dbname;
}
?>
