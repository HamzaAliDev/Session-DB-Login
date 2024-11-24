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
    // Include the database connection file
    require_once 'db_connection.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the title and description from the form
        $title = $_POST['title'];
        $description = $_POST['description'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        // Validate the input data
        if (empty($title) || empty($description) || empty($startDate) || empty($endDate)) {
            echo "Please fill all the inputs";
            echo " <button><a href='add.php'>Go Back</a></button>";
            exit;
        }

        // Get the database connection
        $conn = getDBConnection();

        // Prepare the SQL query
        $sql = "INSERT INTO task (title, description, startDate, endDate) VALUES (?, ?,?,?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters
        $stmt->bind_param("ssss", $title, $description, $startDate, $endDate);

        // Execute the query
        if ($stmt->execute()) {
            echo "Task added successfully!";
        } else {
            echo "Error adding task: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid request method.";
    }
    echo " <button><a href='display.php'>Go Back</a></button>";

    ?>

</body>

</html>