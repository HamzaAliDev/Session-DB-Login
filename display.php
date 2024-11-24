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
    <title>Document</title>
</head>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<body>
    <h3>Welcome, you are logged in! &nbsp; &nbsp; &nbsp; <button><a href="logout.php">Logout</a></button></h3>

    <h1>Task List</h1>
    <br />
    <button><a href="add.php">Add New Task</a></button><br /><br />
    <?php
    // display.php
    require_once 'db_connection.php';

    // Get the database connection
    $conn = getDBConnection();

    // SQL query to select username, password, and email
    $sql = "SELECT * FROM task ORDER BY userId DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Start HTML table
    
        echo "<table border='1'>
            <tr>
            <th>Task Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Start-Date</th>
            <th>End-Date</th>
            <th>User Id</th>
            <th>View Task</th>
            <th>Update Task</th>
            <th>Delete Task</th>
        </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["taskId"] . "</td>
                <td>" . $row["title"] . "</td>
                <td>" . $row["description"] . "</td>
                <td>" . $row["startDate"] . "</td>
                <td>" . $row["endDate"] . "</td>
                <td>" . $row["userId"] . "</td>
                <td><a href='view.php?taskId=" . $row['taskId'] . "'>View</a></td>
                <td><a href='update.php?taskId=" . $row['taskId'] . "'>Update</a></td>
                <td><a href='delete.php?taskId=" . $row['taskId'] . "' onclick='return confirm(\"Are you sure you want to delete this task?\");'>Delete</a></td>
              </tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }

    // Close the connection
    $conn->close();
    ?>
    <br />


</body>

</html>