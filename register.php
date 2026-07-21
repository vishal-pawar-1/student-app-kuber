<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $department = $_POST['department'];

    $sql = "INSERT INTO students(name,email,phone,course,department)
            VALUES('$name','$email','$phone','$course','$department')";

    if($conn->query($sql)){
        header("Location: students.php");
        exit();
    }else{
        echo "Error : " . $conn->error;
    }
}
?>