<?php
// Запускаем сессию, если она еще не запущена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Подключаем необходимые файлы с конфигурацией, функциями и обработчиками
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

$errors = []; // массив для хранения сообщений об ошибках

// Обработка формы, если метод запроса — POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Определяем, какие поля ожидаем из формы
    $fields = ['email', 'password'];

    // Получаем очищенные данные из POST (возможно, с trim)
    $formData = getPostData($fields);

    // Переносим данные в отдельные переменные для удобства
    $email = $formData['email'];
    $password = $formData['password'];

    // Проверяем, что оба поля заполнены
    if (!$email || !$password) {
        $errors[] = 'Заполните все поля'; // добавляем сообщение об ошибке
    }

    // Если ошибок нет, продолжаем проверять пользователя
    if (empty($errors)) {
        // Проверяем, существует ли пользователь с таким email и совпадает ли пароль
        $userData = authenticateUser($pdo, $email, $password);

        if ($userData) {
            // Если данные верны — устанавливаем сессию (логиним пользователя)
            setUserSession($userData['id'], $userData['email']);

            // Перенаправляем на страницу профиля
            header('location: ../../pages/profile.php');
            exit();
        } else {
            // Если пользователь не найден или пароль не совпал — ошибка аутентификации
            $errors[] = 'Неверный email или пароль';

            // Сохраняем ошибки в сессию, чтобы показать на странице входа
            $_SESSION['errors'] = $errors;

            // Перенаправляем обратно на страницу логина с параметром, чтобы отобразить форму входа
            header('location: ../../pages/auth.php?name=login');
            exit();
        }
    } else {
        // Если есть ошибки (например, пустые поля), тоже сохраняем и перенаправляем
        $_SESSION['errors'] = $errors;
        header('location: ../../pages/auth.php?name=login');
        exit();
    }
}
?>
