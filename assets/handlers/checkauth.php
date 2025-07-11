<?php
// Подключаем файл конфигурации, где определены константы и настройки
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Функция для проверки аутентификации пользователя
function checkAuth(): void {
    // Проверяем, установлены ли в сессии идентификатор пользователя и email
    // Если ни user_id, ни email не установлены — значит пользователь не авторизован
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['email'])) {
        // Перенаправляем пользователя на страницу входа (login)
        header('Location:' . BASE_URL . '/pages/auth.php?name=login');
        // Завершаем выполнение скрипта после редиректа
        exit();
    }
}
?>
