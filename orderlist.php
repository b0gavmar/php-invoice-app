<?php
session_start();
$connect = new PDO(dsn: 'mysql:host=localhost;dbname=php_invoice_app',username: 'root');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $connect->prepare("SELECT * FROM orders WHERE user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendeléseim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">PHP Invoice App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="orderlist.php">Rendeléseim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger bg-dark rounded fw-bold" href="logout.php">Kijelentkezés</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container bg-white my-2 p-2 rounded">
        <h1>Rendeléseim</h1>
        <div id="show_alert"></div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Rendelés ID</th>
                    <th scope="col">Összeg</th>
                    <th scope="col">Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['sum']; ?> Ft</td>
                    <td>
                        <a href="pdf.php?order_id=<?php echo $order['id']; ?>" class="btn btn-primary">Számla letöltése</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>