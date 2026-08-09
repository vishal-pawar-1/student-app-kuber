<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student_ Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>Student Registration</h2>

    <form action="register.php" method="POST">

        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone</label>
        <input type="text" name="phone" required>

        <label>Course</label>
        <input type="text" name="course" required>

        <label>Department</label>
        <input type="text" name="department" required>

        <button type="submit">Register Student</button>

    </form>

    <br>

    <a class="view-btn" href="students.php">View Students</a>

</div>

</body>
</html>