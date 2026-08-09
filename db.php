<?php

$host = "mysql";
$user = "root";
$password = "root123";
$database = "studentdb";

/* Connect to MySQL server */
$conn = new mysqli($host, $user, $password);

/* Check connection */
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

/* Create database if it does not exist */
$conn->query("CREATE DATABASE IF NOT EXISTS studentdb");

/* Select database */
$conn->select_db($database);

/* Create students table if it does not exist */
$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    department VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($sql)) {
    die("Table creation failed: " . $conn->error);
}

/* Set UTF-8 */
$conn->set_charset("utf8mb4");

?>