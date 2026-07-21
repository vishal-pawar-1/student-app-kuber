<?php
include 'db.php';

$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container" style="width:90%;">

<h2>Registered Students</h2>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Course</th>
    <th>Department</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['name']; ?></td>
    <td><?= $row['email']; ?></td>
    <td><?= $row['phone']; ?></td>
    <td><?= $row['course']; ?></td>
    <td><?= $row['department']; ?></td>
</tr>

<?php } ?>

</table>

<br>

<a class="view-btn" href="index.php">Add Student</a>

</div>

</body>
</html>