<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Farm Equipment Products</title>
<link rel="stylesheet" href="products.css">
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
.equipment-list {
text-align: center;
}
.product-grid {
display: flex;
flex-wrap: wrap;
justify-content: center;
gap: 30px;
margin-top: 20px;
}
.product-card {
background: white;
border-radius: 8px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
padding: 15px;
width: 300px; /* Adjust width as needed */
display: flex;
flex-direction: row; /* Align items in a row */
align-items: center; /* Center items vertically */
gap: 15px; /* Space between image and text */
}
.product-image {
width: 80px; /* Set a fixed width for the image */
height: auto; /* Maintain aspect ratio */
border-radius: 4px;
}
.product-info {
text-align: left; /* Align text to the left */
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
.rent-button button {
border: none;
background: none;
color: inherit;
cursor: pointer;
font-size: inherit;
}
</style>
</head>
<body>
<nav class="navbar">
<div class="navbar__container">
<a href="index.html" id="navbar__logo"><i class="fas fa-gem"></i> AgriRentals</a>
<div class="navbar__toggle" id="mobile-menu">
<span class="bar"></span>
<span class="bar"></span>
<span class="bar"></span>
</div>
<ul class="navbar__menu">
<li class="navbar__item">
<a href="index.html" class="navbar__links">Home</a>
</li>
<li class="navbar__item">
<a href="tech.html" class="navbar__links">Our Story</a>
</li>
<li class="navbar__item">
<a href="products.php" class="navbar__links">Equipment</a>
</li>
<li class="navbar__btn">
<a href="ContactUs.html" class="navbar__links">Contact Us</a>
</li>
</ul>
</div>
</nav>

<header>
<h1>Farm Equipment Products</h1>
</header>

<section class="equipment-list">
<h2>Available Equipment</h2>
<div class="product-grid">
<?php
include 'fetch_equipment.php';

if (isset($equipment) && is_array($equipment) && count($equipment) > 0) {
foreach ($equipment as $item) {
echo '<div class="product-card">';
echo '<img src="' . htmlspecialchars($item['image_path']) . '" alt="Product Image" class="product-image">';
echo '<div class="product-info">';
echo '<h3>' . htmlspecialchars($item['name']) . '</h3>';
echo '<p>' . htmlspecialchars($item['description']) . '</p>';
echo '<p class="price">Price: $' . htmlspecialchars($item['price']) . '</ p>';
echo '<a href="process_payment.php?equipment_id=' . htmlspecialchars($item['id']) . '" class="rent-button">';
echo '<button>Rent</button>';
echo '</a>';
echo '</div>';
echo '</div>';
}
} else {
echo '<p>No More equipment available at this time.</p>';
}
?>
</div>
</section>

<script>
function rentEquipment(id) {
alert('Equipment with ID ' + id + ' has been rented.');
}
</script>
</body>
</html>