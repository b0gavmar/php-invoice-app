<?php
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;

$connect = new PDO(dsn: 'mysql:host=localhost;dbname=php_invoice_app',username: 'root');

$sql = 'SELECT * FROM orders';
$stmt = $connect->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
$i = 1;

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        table,td,th{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>
            Invoice
        </h2>

        <table>
            <thead>
                <tr>
                    <th>Row Number</th>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>';

foreach ($rows as $row) {
    $html .=    '<tr>
                    <td>'. $i .'</td>
                    <td>'. $row['id'].'</td>
                    <td>'. $row['name'].'</td>
                    <td>'. number_format($row['price'],2).'</td>
                    <td>'. $row['quantity'].'</td>
                    <td>'. number_format($row['price'] * $row['quantity'] ,2).'</td>
                </tr>';
    $total += $row['price'] * $row['quantity'];
    $i++;
};

$html .= '            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5">Total</th>
                    <th>'.number_format($total,2).'</th>
                </tr>
            </tfoot>
        </table>
    </div>
    
</body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
$dompdf->stream('invoice.pdf');
