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
    <h1>Update Task</h1>
    <?php
    // Include database connection
    require_once 'db_connection.php';

    // Check if taskId is set in the URL (GET request)
    if (isset($_GET['taskId'])) {
        $taskId = $_GET['taskId'];

        // Get the database connection
        $conn = getDBConnection();

        // Retrieve the task details using the taskId
        $sql = "SELECT * FROM task WHERE taskId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $taskId);
        $stmt->execute();
        $result = $stmt->get_result();

        // If the task exists, display the form with current values
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <form action="update.php" method="POST">
                <label for="taskId">TaskId</label>
                <input type="text" name="taskId" value="<?php echo $row['taskId']; ?>" readonly /><br /><br />
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo $row['title']; ?>" required><br /><br />

                <label for="description">Description:</label>
                <input name="description" value="<?php echo $row['description']; ?>" required><br><br />

                <label for="startDate">Start Date</label>
                <input type="date" name="startDate" id="startDate" value="<?php echo $row['startDate']; ?>" required><br><br />

                <label for="endDate">End Date</label>
                <input type="date" name="endDate" id="endDate" value="<?php echo $row['endDate']; ?>" required><br><br />

                <label for="userId">UserId</label>
                <input type="number" name="userId" value="<?php echo $row['userId']; ?>" /><br /><br />

                <button type="submit">Update Task</button>
            </form>

            <?php
        } else {
            echo "Task not found.";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }

    // Check if the form is submitted (POST request)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $taskId = $_POST['taskId'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $userId = $_POST['userId'];

        // Get the database connection
        $conn = getDBConnection();

        // Update query
        $sql = "UPDATE task SET title = ?, description = ?, startDate = ?, endDate = ?, userId = ? WHERE taskId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $title, $description, $startDate, $endDate, $userId, $taskId);

        // Execute the query
        if ($stmt->execute()) {
            echo "Task updated successfully!";
        } else {
            echo "Error updating task: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>

    <br /><br />
    <button><a href="display.php">Go Back</a></button>
</body>

</html>