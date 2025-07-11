<?php
function validateFormData(
    ?PDO $pdo,           // Объект подключения к базе данных (может быть null)
    ?string $name,       // Имя пользователя (может быть null)
    ?string $email,      // Email пользователя (может быть null)
    ?string $password,   // Пароль (может быть null)
    ?string $confirmPassword // Подтверждение пароля (может быть null)
): array {
    // Массив для хранения сообщений об ошибках валидации
    $errors = [];

    // Проверяем, что все поля заполнены (не пусты и не null)
    if (!$name || !$email || !$password || !$confirmPassword) {
        $errors[] = 'Заполните все поля';
    }

    // Проверяем корректность email с помощью встроенной функции PHP
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный email';
    }

    // Проверяем, совпадают ли пароль и подтверждение пароля
    if ($password !== $confirmPassword) {
        $errors[] = 'Пароли не совпадают';
    }

    // Проверяем длину пароля (минимум 6 символов)
    if (strlen($password) < 6) {
        $errors[] = 'Пароль должен быть не менее 6 символов';
    }

    // Проверяем, существует ли уже пользователь с таким email в базе данных
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = 'Email уже используется';
    }

    // Возвращаем массив с ошибками, если их нет — массив будет пустым
    return $errors;
}
?>
