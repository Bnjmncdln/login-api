<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "user");

    $query = ("SELECT * FROM users");

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate user input
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION["username"] = $user["username"];
        echo "Message: Authenticated Successfully";
        echo "<br>Status: Success";  
        echo "<br>Token: ";
        echo md5 ($username);
        echo '<br><a href="logout.php">Logout</a>';

    }else{
        echo "Message: Invalid username or password";
        echo "<br>Status: Error";
        echo '<br><a href="index.php">Back</a>';
    }
}