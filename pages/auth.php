<?php
// проверка сессиии
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// если пользователь уже вошел редирект его на индекс
if (isset($_SESSION['user_id'])) {
  header('location: ../index.php');
}
// Подключаем файлы конфигурации, БД и необходимые функции
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

//что бы хедер и футтер заработал передаем константу
define('APP_STARTED', true);

// передаем ошибку валидации через сессии 
$errors = $_SESSION['errors'] ?? [];

// удаляем данные с сессии еррорс
unset($_SESSION['errors']);


?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Вход / Регистрация</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/index.css" />
  <script type="module" src="../assets/js/index.js" defer></script>
</head>

<body>
  <!-- передаем хедер -->
  <?php require_once '../templates/header.php' ?>

  <main class="auth">
    <div class="auth__container">
      <div class="auth__form auth__form--login">
        <h2 class="auth__title">Вход</h2>
        <form class="auth__form-content" action="../assets/handlers/login.php" method="post">
          <input name="email" type="email" class="auth__input" placeholder="Электронная почта" required />
          <input name="password" type="password" class="auth__input" placeholder="Пароль" required />
          <button type="submit" class="auth__button">Войти</button>
        </form>
        <p class="auth__text">
          Нет аккаунта?
          <a href="#register" class="auth__link">Зарегистрироваться</a>
        </p>
        <br>
        <!-- проверка есть ли ошибки -->
        <?php if (!empty($errors)): ?>
          <div class="error-messages">
            <ul>
              <!-- выводим ошики если есть -->
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>

      <div class="auth__form auth__form--register hidden">
        <h2 class="auth__title">Регистрация</h2>
        <form class="auth__form-content" action="../assets/handlers/register.php" method="post">
          <input name="user-name" type="text" class="auth__input" placeholder="Имя пользователя" required />
          <input name="email" type="email" class="auth__input" placeholder="Электронная почта" required />
          <input name="password" type="password" class="auth__input" placeholder="Пароль" required />
          <input name="password-confirm" type="password" class="auth__input" placeholder="Повторный пароль" required />
          <button type="submit" class="auth__button">
            Зарегистрироваться
          </button>
        </form>
        <p class="auth__text">
          Уже есть аккаунт?
          <a href="#login" class="auth__link">Войти</a>
        </p>
        <br>
        <!-- проверка есть ли ошибок -->
        <?php if (!empty($errors)): ?>
          <div class="error-messages">
            <ul>
              <!-- вывод ошибок если есть -->
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach ?>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>
  <?php require_once '../templates/footer.php' ?>

</body>

</html>