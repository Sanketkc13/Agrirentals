<?php
$conn = new mysqli('localhost', 'root', 'sanket', 'agrirentals');
$result = $conn->query("SELECT * FROM equipment");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="equipment-item">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['description'] . '</p>';
        echo '<p>Price: $' . $row['price'] . '/day</p>';
        echo '</div>';
    }
} else {
    echo '<p>No equipment available at the moment.</p>';
}

$conn->close();
?>