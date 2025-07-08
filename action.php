<?php
session_start();
require_once 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;

$connect = new PDO(dsn: 'mysql:host=localhost;dbname=php_invoice_app',username: 'root');

$orderId = Uuid::uuid4()->toString();;

$stmt = $connect->prepare("INSERT INTO orders (id, sum) VALUES (:id, 0)");
$stmt->execute(['id' => $orderId]);


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

$token = bin2hex(random_bytes(16));
$_SESSION['order_tokens'][$orderId] = $token;

echo json_encode([
    "status" => "ok",
    "order_id" => $orderId,
    "token" => $token
]);