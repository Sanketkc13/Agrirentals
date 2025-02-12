<?php
require_once("dbConnection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "DELETE FROM equipment WHERE id = $id");

    if ($result) {
        echo "Equipment deleted successfully!";
        header("Location: admin_service.html");
    } else {
        echo "Error deleting equipment: " . mysqli_error($mysqli);
    }
}
?>