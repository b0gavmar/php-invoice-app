<?php

require_once 'vendor/autoload.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Invoice</title>
    <style>
        table,td,th{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center fw-bold">
            Invoice
        </h2>

        <table class="table border">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="">Total</th>
                    <th>1</th>
                </tr>
            </tfoot>
        </table>
    </div>
    
</body>
</html>