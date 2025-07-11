<?php
// протсо подключаем бд
$host = 'localhost';
$dbname = 'movies_db';
$username = 'magnatavr';
$password = '000111';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "ошибка подключения к бд - " . $e->getMessage();
    exit();
}

?>