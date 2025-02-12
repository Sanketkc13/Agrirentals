<?php
session_start();

$admin_email = "admin@gmail.com"; 
$admin_password = "admin"; 

$servername = "localhost"; 
$username = "root"; 
$password = "sanket"; 
$dbname = "agrirentals"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $input_email = $_POST['email'];
    $input_password = $_POST['password'];

    if ($input_email === $admin_email && $input_password === $admin_password) {
        header("Location: admin.html");
        exit();
    } else {
        $stmt = $conn->prepare("SELECT id, name FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $input_email, $input_password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $input_email
            ];
            header("Location: index.html");
            exit();
        } else {

            $_SESSION['error_message'] = "Invalid email or password.";
            header("Location: login.php");
            exit();
        }
    }
} else {
    $_SESSION['error_message'] = "Please fill in both fields.";
    header("Location: login.php");
    exit();
}

$conn->close();
?>