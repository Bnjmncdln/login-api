<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = new PDO('mysql:host=localhost;dbname=user','root','');

    $query = ("SELECT * FROM users");

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate user input
    $query = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

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