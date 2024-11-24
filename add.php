<?php
session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
</head>

<body>
    <h3>Welcome, you are logged in! &nbsp; &nbsp; &nbsp; <button><a href="logout.php">Logout</a></button></h3>
    <h1>Add New Task</h1>
    <form action="create.php" method="POST">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required /><br /><br />
        <label for="description">Description</label>
        <input type="text" name="description" id="description" required /><br /><br />
        <label for="startDate">Start Date</label>
        <input type="date" name="startDate" id="startDate" required /><br /><br />
        <label for="endDate">End Date</label>
        <input type="date" name="endDate" id="endDate" required /><br /><br />
        <input type="submit" />
        <button><a href="display.php">Go Back</a></button>
    </form>

</body>

</html>