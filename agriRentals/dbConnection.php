<?php
$mysqli = new mysqli('localhost', 'root', 'sanket', 'agrirentals');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function deleteEquipment($id)
{
    global $mysqli;
    $query = "DELETE FROM equipment WHERE id = $id";
    mysqli_query($mysqli, $query);
}
?>