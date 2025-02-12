<?php
$servername = "localhost"; 
$username = "root"; 
$password = "sanket"; 
$dbname = "agrirentals"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $password, $id);
    
    if ($stmt->execute()) {
        header("Location: admin_page.php");
        exit;
    } else {
        echo "Error updating user: " . $conn->error;
    }
    $stmt->close();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User  not found.";
        exit;
    }
    $stmt->close();
} else {
    echo "No user ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="admin-container">
        <h1>Edit User</h1>
        <form method="POST" action="edit_user.php">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" value="<?php echo $user['password']; ?>" required>
            <br>
            <button type="submit" name="update">Update User</button>
        </form>
        <a href="admin_page.php">Back to Users</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>