<?php
require 'load.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {

    } else {
        $stmt = $connect->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
        
        header("Location: login.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
    <div class="container bg-white my-2 p-2 rounded">
        <h1>Regisztráció</h1>
        <form method="POST">
            <input class="form-control m-2" type="email" name="email" placeholder="Email" required>
            <input class="form-control m-2" type="password" name="password" placeholder="Jelszó" required>
            <button class="btn btn-primary m-2" type="submit">Regisztráció</button>
            <button class="btn btn-success"><a href="login.php" style="text-decoration:none; color: white;">Bejelentkezés</a></button>
        </form>

    </div>
    
</body>
</html>