<?php

//print_r($_POST);
$connect = new PDO(dsn: 'mysql:host=localhost;dbname=php_invoice_app',username: 'root');

/*$itemNames = $_POST['item_name'];
$itemPrices = $_POST['item_price'];
$itemQtys = $_POST['item_qty'];


for ($i = 0; $i < count($itemNames); $i++) {
    $sql = 'INSERT INTO orders(name,price,quantity) VALUES(:name,:price,:qty)';
    $stmt = $connect->prepare($sql);
    $stmt->execute([
        ':name' => $itemNames[$i],
        ':price' => $itemPrices[$i],
        ':qty' => $itemQtys[$i],
    ]);
}
*/

$stmt = $connect->prepare("INSERT INTO orders (sum) VALUES (0)");
$stmt->execute();
$orderId = $connect->lastInsertId();

$sum = 0;

foreach($_POST['item_id'] as $key => $itemId){
    $qty = $_POST['item_qty'][$key];

    $stmtPrice = $connect->prepare("SELECT price FROM items WHERE id = :id");
    $stmtPrice->execute(['id' => $itemId]);
    $price = $stmtPrice->fetchColumn();

    $stmtInsert = $connect->prepare("INSERT INTO order_items (order_id, item_id, quantity) VALUES (:orderId, :itemId, :qty)");
    $stmtInsert->execute([  'orderId' => $orderId, 
                                    'itemId' => $itemId,
                                    'qty' => $qty]);

    $sum += $price * $qty;
}

$stmtUpdate = $connect->prepare('UPDATE orders SET sum = :sum WHERE id = :id');
$stmtUpdate->execute(['sum' => $sum, 'id' => $orderId]);

echo 'Items inserted';