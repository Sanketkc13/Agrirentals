<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Equipment Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }
        .product-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .product-image {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }
        .product-info {
            text-align: center;
        }
        .price {
            font-weight: bold;
            margin: 10px 0;
        }
        .rent-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .rent-button:hover {
            background-color: #0056b3;
        }
        .no-equipment {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #666;
        }
    </style>
</head>
<body>

<header>
    <h1>Farm Equipment Products</h1>
</header>

<div class="product-grid">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "sanket";
    $dbname = "agrirentals";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, name, description, price, image FROM equipment"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image">';
            echo '<div class="product-info">';
            echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '<p class="price">$' . htmlspecialchars($row['price']) . '</p>';
            echo '<a href="process_payment.php?equipment_id=' . htmlspecialchars($row['id']) . '" class="rent-button"><button>Rent</button></a>';
            echo '</div>'; 
            echo '</div>'; 
        }
    } else {
        echo '<div class="no-equipment">No More equipment found.</div>'; 
    }

    $conn->close();
    ?>
</div>

</body>
</html>