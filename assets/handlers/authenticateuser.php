<?php 
// Функция для аутентификации пользователя по email и паролю
// Принимает объект PDO для работы с базой, email и пароль пользователя
// Возвращает массив с данными пользователя, если аутентификация успешна, или false — если нет
function authenticateUser(PDO $pdo, string $email, string $password): array|false {
    
    // Подготавливаем SQL-запрос для выбора пользователя по email
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    
    // Выполняем запрос с передачей email
    $stmt->execute([$email]);

    // Получаем данные пользователя из базы (ассоциативный массив)
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Если пользователь найден и проверка пароля успешна
    // password_verify сравнивает переданный пароль с хешем в базе
    if ($user && password_verify($password, $user['password'])) {
        // Возвращаем данные пользователя
        return $user;
    }

    // Если пользователь не найден или пароль не подошёл, возвращаем false
    return false;
}
?>
