<?php
session_start();

$connect = new PDO(dsn: 'mysql:host=localhost;dbname=php_invoice_app',username: 'root');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {

    } else {
        $stmt = $connect->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belépés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
    <div class="container bg-white my-2 p-2 rounded">
        <h1>Bejelentkezés</h1>
        <form method="POST">
            <input class="form-control m-2" type="email" name="email" placeholder="Email" required>
            <input class="form-control m-2" type="password" name="password" placeholder="Jelszó" required>
            <button class="btn btn-primary m-2" type="submit">Belépés</button>
            <button class="btn btn-success"><a href="register.php" style="text-decoration:none; color: white;">Regisztráció</a></button>
        </form>

    </div>
    
</body>
</html>