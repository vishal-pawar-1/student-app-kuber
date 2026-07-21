<?php

$host = "mysql";      // Kubernetes मध्ये हा Service name असेल
$user = "root";
$password = "root123";
$database = "studentdb";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>