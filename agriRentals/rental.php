<?php
class RentalSystem {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function calculateRentalPrice($basePrice, $rentalDays, $additionalFees = 0) {
        $totalPrice = $basePrice * $rentalDays;

        if ($rentalDays > 14) {
            $discount = 0.15;
        } elseif ($rentalDays > 7) {
            $discount = 0.10;
        } else {
            $discount = 0;
        }

        $discountAmount = $totalPrice * $discount;
        $totalPrice -= $discountAmount;
        $totalPrice += $additionalFees;

        return $totalPrice;
    }

    public function getEquipmentList() {
        $sql = "SELECT id, name, description, base_price, image FROM equipment";
        $result = $this->conn->query($sql);
        $equipmentList = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $equipmentList[] = $row;
            }
        }

        return $equipmentList;
    }
}

$servername = "localhost";
$username = "root";
$password = "sanket";
$dbname = "rentals";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rentalSystem = new RentalSystem($conn);

$basePrice = 100;
$rentalDays = 10;
$additionalFees = 20;

$totalPrice = $rentalSystem->calculateRentalPrice($basePrice, $rentalDays, $additionalFees);
echo "Total Rental Price: $" . number_format($totalPrice, 2) . "<br>";

$equipmentList = $rentalSystem->getEquipmentList();
foreach ($equipmentList as $equipment) {
    echo "ID: " . $equipment['id'] . " - Name: " . $equipment['name'] . " - Base Price: $" . $equipment['base_price'] . "<br>";
}

$conn->close();
?>