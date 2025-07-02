<?php

$connect = new PDO(dsn: 'mysql:host=localhost;dbname=php_invoice_app',username: 'root');

$stmt = $connect->query("SELECT id, name, price FROM items");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($items);