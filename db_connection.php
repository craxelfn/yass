<?php
// Database connection parameters
$host = "localhost"; // Change this to your MySQL host
$user = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "cotest"; // Change this to your MySQL database name

// Create connection
$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
