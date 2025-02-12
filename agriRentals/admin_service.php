<?php
require_once("dbConnection.php");

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($mysqli, $_POST['search']);
}

if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $deleteQuery = "DELETE FROM equipment WHERE id = $id";
    mysqli_query($mysqli, $deleteQuery);
    header('Location: admin_service.php');
    exit;
}

$query = "SELECT * FROM equipment WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($mysqli, $query);

$totalQuery = "SELECT COUNT(*) as total FROM equipment WHERE name LIKE '%$search%'";
$totalResult = mysqli_query($mysqli, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalEntries = $totalRow['total'];
$totalPages = ceil($totalEntries / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Equipment - AgriRentals</title>
    <link rel="stylesheet" href="ourequipment.css">
</head>
<body>
    <section id="menu">
        <div class="logo">
            <img src="images/logo.png" alt="">
            <h2>AgriRentals</h2>
        </div>
        <div class="items">
            <li><i class="fa-solid fa-chart-pie"></i><a href="admin.html">Dashboard</a></li>
            <li><i class="fa-solid fa-chart-line"></i><a href="add_equipment.html">Equipment</a></li>
            <li><i class="fa-solid fa-table-list"></i><a href="admin_page.php">Users</a></li>
            <li><i class="fa-solid fa-suitcase"></i><a href="admin_service.php">Our Equipment</a></li>
        </div>
    </section>
    
    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div>
                    <i id="menu-btn" class="fa-solid fa-heart"></i>
                </div>
            </div>
        </div>
        <div class="container">
            <h1>Manage Equipment</h1>
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Search Equipment" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
            <table width='100%'>
                <tr>
                    <th>Equipment Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                <?php while ($res = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($res['name']); ?></td>
                    <td><?php echo htmlspecialchars($res['description']); ?></td>
                    <td><?php echo htmlspecialchars($res['price']); ?></td>
                    <td>
                        <a href="admin_service.php?delete_id=<?php echo $res['id']; ?>" onClick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>
