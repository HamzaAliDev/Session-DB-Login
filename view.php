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

<body>
    <h3>Welcome, you are logged in! &nbsp; &nbsp; &nbsp; <button><a href="logout.php">Logout</a></button></h3>
    <h1>Task Details</h1>
    <?php
    // include connection file
    require_once 'db_connection.php';

    if (isset($_GET['taskId'])) {
        $taskId = $_GET['taskId'];

        $conn = getDbConnection();

        $sql = "SELECT * FROM task WHERE taskId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $taskId);
        $stmt->execute();
        $result = $stmt->get_result();

        //check if task is exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<p><strong>Task Id:</strong> " . $row['taskId'] . "</p>";
            echo "<p><strong>Title:</strong> " . $row['title'] . "</p>";
            echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
            echo "<p><strong>Start Date:</strong> " . $row['startDate'] . "</p>";
            echo "<p><strong>End Date:</strong> " . $row['endDate'] . "</p>";
            echo "<p><strong>User Id:</strong> " . $row['userId'] . "</p>";
        } else {
            echo "Task not found.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Something went wrong";
    }

    ?>

    <br />
    <button><a href="display.php">Go Back</a></button>
</body>

</html>