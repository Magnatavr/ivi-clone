<?php
// Проверяем, запущена ли сессия, если нет — запускаем
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Подключаем необходимые файлы:
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';


// Проверяем, есть ли уже авторизованный пользователь (user_id в сессии)
// Если да — перенаправляем на главную (не даём зарегистрироваться повторно)
if (isset($_SESSION['user_id'])) {
    header('location: ../../index.php');
    exit();
}

// Обрабатываем данные, если метод запроса — POST (форма отправлена)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Определяем, какие поля мы ожидаем из формы
    $fields = ['user-name', 'email', 'password', 'password-confirm'];

    // Получаем данные из POST через функцию (например, с обрезкой пробелов)
    $formData = getPostData($fields);

    // Записываем значения в удобные переменные
    $name = $formData['user-name'];
    $email = $formData['email'];
    $password = $formData['password'];
    $confirmPassword = $formData['password-confirm'];

    // Валидируем полученные данные (например, проверяем email, длину пароля, совпадение паролей)
    $errors = validateFormData(
        $pdo,
        $name,
        $email,
        $password,
        $confirmPassword
    );

    // Если валидация прошла успешно (ошибок нет)
    if (empty($errors)) {
        // Создаём пользователя в базе и получаем его ID
        $userID = createUser($pdo, $name, $email, $password);

        // Устанавливаем данные пользователя в сессию (логиним)
        setUserSession($userID, $email);

        // Перенаправляем на профиль пользователя
        header('location: ../../pages/profile.php');
        exit();

    } else {
        // Если есть ошибки — сохраняем их в сессию, чтобы показать на странице регистрации
        $_SESSION['errors'] = $errors;

        // Перенаправляем обратно на форму регистрации
        header('location: ../../pages/auth.php?name=register');
        exit();
    }
}
?>
