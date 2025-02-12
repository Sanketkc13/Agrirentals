<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nameToRemove = $_POST['name'];

    $currentData = json_decode(file_get_contents('equipment.json'), true);
    $updatedData = array_filter($currentData, function($item) use ($nameToRemove) {
        return $item['name'] !== $nameToRemove;
    });

    file_put_contents('equipment.json', json_encode(array_values($updatedData)));
    header('Location: product.html');
    exit();
}
?>