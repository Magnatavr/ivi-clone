<?php
// Запускаем сессию, если она еще не запущена
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Подключаем конфигурации, подключение к БД и вспомогательные функции
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

// Для корректной работы header и footer, если они используют APP_STARTED
define('APP_STARTED', true);

// Проверка авторизации пользователя (если не авторизован — редирект или ошибка)
checkAuth();

// Получаем ID авторизованного пользователя из сессии
$userID = $_SESSION['user_id'];

// Получаем данные пользователя из базы данных
$user = getUserData($pdo, $userID);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <title>Профиль пользователя</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/index.css" />
</head>

<body>

  <!-- Шапка сайта -->
  <?php require_once '../templates/header.php' ?>

  <main class="profile">
    <h1 class="profile__title">Профиль пользователя</h1>

    <div class="profile__info">
      <div class="profile__avatar-container">
        <img
          src="<?= $user['avatar'] ? htmlspecialchars($user['avatar']) : BASE_URL . '/assets/img/avatar/default-avatar.png' ?>"
          alt="Аватар пользователя" class="profile__avatar" />
      </div>

      <div class="profile__details">
        <p class="profile__name">
          Имя: <span class="profile__value"><?= htmlspecialchars($user['name']) ?></span>
        </p>
        <p class="profile__email">
          Email: <span class="profile__value"><?= htmlspecialchars($user['email']) ?></span>
        </p>

        <br>

        <div class="profile_btns">
          <a href="./edit-profile.php" class="profile__edit-button">Редактировать профиль</a>
          <a href="../assets/handlers/logout.php" class="profile__exit-button">Выйти</a>
        </div>
      </div>
    </div>
  </main>

  <!-- Подвал сайта -->
  <?php require_once '../templates/footer.php' ?>

</body>

</html>