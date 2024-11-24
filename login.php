<?php
session_start();

// Include database connection
require_once 'db_connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    // Validate the input data
    if (empty($inputUsername) || empty($inputPassword)) {
        echo 'Please fill all the inputs';
        exit;
    }

    // Get the database connection
    $conn = getDBConnection();

    // Query to check if the user exists
    $sql = "SELECT userName, password FROM user WHERE userName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_Param('s', $inputUsername);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if the user exists and the password is correct
    // if ($row && password_verify($inputPassword, $row['password'])) {
    if ($row && $inputPassword === $row['password']) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $inputUsername;
        header('Location: display.php');
        exit;
    } else {
        $error = "Invalid username or password";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
</head>

<body>
    <h1>Login Page</h1>
    <form action="" method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>

    <?php
    if (isset($error)) {
        echo '<p style="color:red;">' . $error . '</p>';
    }
    ?>
</body>

</html>