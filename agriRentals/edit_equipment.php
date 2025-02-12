<?php
require_once("dbConnection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM equipment WHERE id = $id");
    $res = mysqli_fetch_assoc($result);
}
?>

<form action="update_equipment.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
    <label for="name">Equipment Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $res['name']; ?>" required>
    
    <label for="description">Description:</label>
    <textarea id="description" name="description" required><?php echo $res['description']; ?></textarea>
    
    <label for="price">Renting Price:</label>
    <input type="number" id="price" name="price" value="<?php echo $res['price']; ?>" step="0.01" required>
    
    <button type="submit">Update Equipment</button>
</form>