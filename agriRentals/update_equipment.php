<?php
require_once("dbConnection.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);
    $price = mysqli_real_escape_string($mysqli, $_POST['price']);

    $result = mysqli_query($mysqli, "UPDATE equipment SET name='$name', description='$description', price='$price' WHERE id=$id");

    if ($result) {
        echo "Equipment updated successfully!";
        header("Location: admin_service.html");
    } else {
        echo "Error updating equipment: " . mysqli_error($mysqli);
    }
}
?>