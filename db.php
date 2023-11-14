<?php
// Database connection parameters
$host = "localhost";  // Replace with your database host
$username = "root";  // Replace with your database username
$password = "";  // Replace with your database password
$database = "hr_consultancy";  // Replace with your database name

// Create a database connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
