<?php

//print_r($_POST);
$connect = new PDO(dsn: 'mysql:host=localhost;dbname=php_invoice_app',username: 'root');
foreach($_POST['item_name'] as $key => $value){
    $sql = 'INSERT INTO items(name,price,quantity) VALUES(:name,:price,:qty)';
    $smtm = $connect->prepare($sql);
    $smtm->execute([
        ':name' => $value,
        ':price' => $_POST['item_price'][$key],
        ':qty' => $_POST['item_qty'][$key],
    ]);
};

echo 'Items inserted';