<?php
$servername = "localhost"; 
$username = "root";
$password = "sanket"; 
$dbname = "agrirentals"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO equipment (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')";
        
        if ($conn->query($sql) === TRUE) {
            
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Equipment</title>
</head>
<body>
    <h1>Add New Equipment</h1>
    <form action="add_equipment.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <label for="price">Price:</label>
        <input type="number" name="price" required>
        <br>
        <label for="image">Image:</label>
        <input type="file" name="image" required>
        <br>
        <input type="submit" value="Add Equipment">
    </form>
</body>
</html>