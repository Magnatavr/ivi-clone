<?php

// Функция для установки данных пользователя в сессию после успешной авторизации или регистрации
function setUserSession(int $userID, string $email): void
{
    // Если сессия еще не запущена, запускаем её
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Записываем ID пользователя в сессию
    $_SESSION['user_id'] = $userID;
    
    // Записываем email пользователя в сессию
    $_SESSION['user_email'] = $email;
}

?>
