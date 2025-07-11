<?php
// Функция для создания нового пользователя в базе данных
// Принимает объект PDO, имя, email и пароль пользователя
// Возвращает ID созданного пользователя (целое число)
function createUser(
    PDO $pdo,
    string $name,
    string $email,
    string $password
): int {
    // Хешируем пароль с помощью безопасного алгоритма по умолчанию
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Подготавливаем SQL-запрос на вставку данных нового пользователя
    $stmt = $pdo->prepare('INSERT INTO users(name, email, password) VALUES(?, ?, ?)');

    // Выполняем запрос с передачей имени, email и захешированного пароля
    $stmt->execute([$name, $email, $hashedPassword]);

    // Возвращаем ID последней вставленной записи (нового пользователя)
    return $pdo->lastInsertId();
}
?>
