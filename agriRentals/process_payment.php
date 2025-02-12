<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "sanket";
$dbname = "agrirentals";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function createRental($conn, $equipment_id, $rental_days) {
    $rental_date = date('Y-m-d H:i:s');
    $status = 'active';
    $sql = "INSERT INTO rentals (equipment_id, user_id, rental_date, rental_days, status) VALUES (?, NULL, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isis", $equipment_id, $rental_date, $rental_days, $status);
    return $stmt->execute();
}

function calculateTotalPrice($price, $rental_days) {
    $total_price = $price * $rental_days;
    if ($rental_days == 7) {
        $total_price *= 0.9; // Apply 10% discount
    }
    return $total_price;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="hidden"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            text-align: center;
        }
        .slider-container {
            margin: 15px 0;
        }
        .slider {
            width: 100%;
        }
        .slider-value {
            text-align: center;
            margin: 10px 0;
        }
        .total-price {
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
        }
        .discount-message {
            color: green;
            text-align: center;
            margin: 10px 0;
            display: none; 
        }
    </style>
    <script>
        function updatePrice(pricePerDay) {
            const rentalDays = document.getElementById('rental_days').value;
            const totalPriceElement = document.getElementById('total_price');
            const discountMessage = document.getElementById('discount_message');
            let totalPrice = pricePerDay * rentalDays;

            if (rentalDays == 7) {
                totalPrice *= 0.9;
                discountMessage.style.display = 'block';
            } else {
                discountMessage.style.display = 'none';
            }

            totalPriceElement.textContent = 'Total Price: $' + totalPrice.toFixed(2);
        }
    </script>
</head>
<body>

<div class="container">
    <?php
    if (isset($_GET['equipment_id'])) {
        $equipment_id = $_GET['equipment_id'];

        $query = "SELECT * FROM equipment WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $equipment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $equipment = $result->fetch_assoc();

        if ($equipment) {
            $price = htmlspecialchars($equipment['price']);
            echo '<h1>Payment for ' . htmlspecialchars($equipment['name']) . '</h1>';
            echo '<p>Price per day: $' . $price . '</p>';
            echo '<form action="" method="POST">';
            echo '<input type="hidden" name ="product_id" value="' . htmlspecialchars($equipment['id']) . '">';
            echo '<label for="rental_days">Select Rental Days:</label>';
            echo '<div class="slider-container">';
            echo '<input type="range" id="rental_days" name="rental_days" min="1" max="7" value="1" class="slider" oninput="this.nextElementSibling.value = this.value; updatePrice(' . $price . ')">';
            echo '<output>1</output>';
            echo '</div>';
            echo '<div id="total_price" class="total-price">Total Price: $' . $price . '</div>';
            echo '<div id="discount_message" class="discount-message">10% discount applied!</div>';
            echo '<label for="card_number">Card Number:</label>';
            echo '<input type="text" id="card_number" name="card_number" required pattern="\d*" maxlength="16">';
            echo '<label for="expiry_date">Expiry Date (MM/YY):</label>';
            echo '<input type="text" id="expiry_date" name="expiry_date" required placeholder="MM/YY" pattern="\d{2}/\d{2}">';
            echo '<label for="cvv">CVV:</label>';
            echo '<input type="text" id="cvv" name="cvv" required pattern="\d*" maxlength="3">';
            echo '<button type="submit">Submit Payment</button>';
            echo '</form>';
        } else {
            echo '<p class="error-message">Equipment not found.</p>';
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['product_id']) && isset($_POST['rental_days'])) {
            $product_id = $_POST['product_id'];
            $rental_days = $_POST['rental_days'];
            $card_number = $_POST['card_number'];
            $expiry_date = $_POST['expiry_date'];
            $cvv = $_POST['cvv'];

            $query = "SELECT * FROM rentals WHERE equipment_id = ? AND return_date IS NULL AND status = 'active'";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                if (createRental($conn, $product_id, $rental_days)) {
                    $_SESSION['message'] = "Payment successful! Visit to receive your equipment.";
                    header("Location: products.php");
                    exit;
                } else {
                    echo '<p class="error-message">Failed to create rental record. Please try again.</p>';
                }                
            } else {
                echo '<p class="error-message">This equipment is already rented.</p>';
            }
        } else {
            echo '<p class="error-message">Invalid request.</p>';
        }
    } else {
        echo '<p class="error-message">Invalid request.</p>';
    }
    ?>
</div>

</body>
</html>

<?php
$conn->close();
?>