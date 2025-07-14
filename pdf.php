<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'vendor/autoload.php';
use Dompdf\Dompdf;

$connect = new PDO(dsn: 'mysql:host=localhost;dbname=php_invoice_app',username: 'root');

$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    die("Hiányzó paraméter.");
}

if (!isset($_SESSION['user_id'])) {
    die("Nincs jogosultság ehhez a rendeléshez.");
}

$stmtOrder = $connect->prepare("SELECT * FROM orders WHERE id = :id AND user_id = :user_id");
$stmtOrder->execute(['id' => $orderId, 'user_id' => $_SESSION['user_id']]);
$order = $stmtOrder->fetch(PDO::FETCH_ASSOC);

$stmtItems = $connect->prepare("
    SELECT order_items.quantity, items.name, items.price
    FROM order_items 
    JOIN items ON items.id = order_items.item_id
    WHERE order_items.order_id = :id
");
$stmtItems->execute(['id' => $orderId]);
$orderItems = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

$dompdf = new Dompdf();

$html = "<h1>Számla #{$order['id']}</h1>";
$html .= "<p>Összesen: {$order['sum']} Ft</p>";
$html .= "<table border='1' cellpadding='5'>
<tr><th>Termék</th><th>Mennyiség</th><th>Egységár</th><th>Összesen</th></tr>";
foreach($orderItems as $item){
    $lineTotal = $item['quantity'] * $item['price'];
    $html .= "<tr>
        <td>{$item['name']}</td>
        <td>{$item['quantity']}</td>
        <td>{$item['price']} Ft</td>
        <td>{$lineTotal} Ft</td>
    </tr>";
}
$html .= "</table>";

$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
$dompdf->stream("szamla_{$order['id']}.pdf");