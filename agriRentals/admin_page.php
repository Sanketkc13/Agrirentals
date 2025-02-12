<?php
$servername = "localhost"; 
$username = "root"; 
$password = "sanket"; 
$dbname = "agrirentals"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "User  deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
    $stmt->close();
}

$result = $conn->query("SELECT id, name, email, password FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="user.css">
    <style>
        .oval-button {
            background-color: #4CAF50; 
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 25px; 
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .oval-button:hover {
            background-color: #45a049; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .admin-container {
            padding: 20px;
        }
    </style>
    <script>
        function deleteUser (id) {
            if (confirm("Are you sure you want to delete this user?")) {
                var formData = new FormData();
                formData.append('delete_id', id);
                
                fetch('admin_page.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload();
                });
            }
        }

        function editUser (id) {
            window.location.href = `edit_user.php?id=${id}`;
        }
    </script>
</head>
<body>
    <nav id="menu">
        <div class="logo">
            <img src="images/logo.png" alt="AgriRentals Logo">
            <h2>AgriRentals</h2>
        </div>
        <ul class="items">
            <li><i class="fas fa-chart-pie"></i><a href="admin.html">Dashboard</a></li>
            <li><i class="fas fa-chart-line"></i><a href="add_equipment.html">Equipment</a></li>
            <li><i class="fas fa-table-list"></i><a href="admin_page.php">Users</a></li>
            <li><i class="fas fa-suitcase"></i><a href="admin_service.php">Our Equipments</a></li>
        </ul>
    </nav>

    <div class="admin-container">
        <h1>Admin Page</h1>

        <button class="oval-button" onclick="window.location.href='add_user.php'">Add User</button>

        <?php
        if ($result) {
            if ($result->num_rows > 0) {
                echo "<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Action</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['password']}</td>
                            <td>
                                <button onclick='editUser ({$row['id']})'>Edit</button>
                                <button onclick='deleteUser ({$row['id']})'>Delete</button>
                            </td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No users found.</p>";
            }
        } else {
            echo "<p>Error executing query: " . $conn->error . "</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>