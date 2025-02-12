<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "sanket";
$dbname = "agrirentals";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password_input = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($password_input, $hashed_password)) {
        $_SESSION['user_email'] = $email;
        header("Location: index.html");
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid email or password.";
    }
} else {
    $_SESSION['error_message'] = "Invalid email or password.";
}

$stmt->close();
$conn->close();

header("Location: login.php");
exit();
?>