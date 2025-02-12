<?php

$result = $conn->query("SELECT id, username, email FROM users");

if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Username</th><th>Email</th><th>Action</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
                <td><button onclick='deleteUser ({$row['id']})'>Delete</button></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}
?>