<?php
$servername = "localhost"; 
$username = "root"; 
$password = "sanket"; 
$dbname = "review"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM inquiries"; 
$result = mysqli_query($conn, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['phone']) . "</td>
                    <td>" . htmlspecialchars($row['message']) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No inquiries found.</td></tr>";
    }
} else {
    echo "<tr><td colspan='4'>Error fetching inquiries: " . mysqli_error($conn) . "</td></tr>";
}

mysqli_close($conn);
?>