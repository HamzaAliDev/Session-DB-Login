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
    <?php
    // delete.php
    require_once 'db_connection.php';

    if (isset($_GET['taskId'])) {
        // Get the taskId from the URL
        $taskId = $_GET['taskId'];

        // Get the database connection
        $conn = getDBConnection();

        // Prepare the SQL query to delete the task
        $sql = "DELETE FROM task WHERE taskId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $taskId);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the task list after successful deletion
            header("Location: display.php");
            exit;
        } else {
            echo "Error deleting task: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "No task ID provided.";
    }
    ?>
</body>

</html>