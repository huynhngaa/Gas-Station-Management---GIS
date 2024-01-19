<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "congty2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Không kết nối: " . $conn->connect_error);
  } ?>