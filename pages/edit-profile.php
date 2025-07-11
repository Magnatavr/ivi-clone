<?php
// Если сессия еще не запущена — запускаем
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Подключаем файлы конфигурации, БД и необходимые функции
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

//что бы хедер и футтер заработал передаем константу
define('APP_STARTED', true);

// Проверяем, авторизован ли пользователь — если нет, перенаправим
checkAuth();

// Создаем массив для хранения ошибок при валидации или загрузке
$errors = [];

// Получаем ID текущего пользователя из сессии
$userID = $_SESSION['user_id'];

// Получаем все данные текущего пользователя из базы
$userData = getUserData($pdo, $userID);

// Сохраняем путь к текущей аватарке пользователя (чтобы удалить её позже, если нужно)
$oldAvatarPath = $userData['avatar'];

// Обрабатываем форму, только если метод запроса — POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ожидаем, что пользователь отправит эти поля
  $fields = ['name', 'email'];

  // Получаем данные из POST-запроса по указанным полям
  $data = getPostData($fields);

  // Переменная для пути новой аватарки (если пользователь загрузит её)
  $avatarPath = null;

  // Проверка: если аватарка загружалась, но возникла ошибка — записываем её
  if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
      $errors[] = 'Ошибка при загрузке: ' . $_FILES['avatar']['error'];
    } else {
      // Папка, куда сохраняются аватарки
      $avatarDir = $_SERVER["DOCUMENT_ROOT"] . '/assets/img/avatar/';

      // Если папка не существует — создаем
      if (!is_dir($avatarDir)) {
        mkdir($avatarDir, 0777, true);
      }

      // Временное имя загруженного файла
      $tmpName = $_FILES['avatar']['tmp_name'];

      // Допустимые типы изображений
      $validTypes = ['image/jpeg', 'image/png', 'image/gif'];

      // Проверяем, что тип загруженного файла — корректный
      if (!in_array(mime_content_type($tmpName), $validTypes)) {
        $errors[] = 'Недопустимый тип изображения';
      }

      // Если ошибок нет — сохраняем новый файл
      if (empty($errors)) {
        // Генерируем уникальное имя файла
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('avatar_', true) . '.' . $ext;

        // Относительный путь к файлу для сохранения в БД
        $avatarPath = '/assets/img/avatar/' . $fileName;

        // Перемещаем файл в нужную папку
        move_uploaded_file($tmpName, $avatarDir . $fileName);

        // Удаляем старую аватарку, если она была
        if (!empty($oldAvatarPath)) {
          $fullOldPath = $_SERVER['DOCUMENT_ROOT'] . $oldAvatarPath;
          if (file_exists($fullOldPath)) {
            unlink($fullOldPath);
          }
        }
      }
    }
  }

  // Если ошибок не было — обновляем данные пользователя в БД
  if (empty($errors)) {
    // Формируем SQL-запрос для обновления данных
    $sql = 'UPDATE users SET name = :name, email = :email';

    // Если была новая аватарка — добавим её в запрос
    if ($avatarPath !== null) {
      $sql .= ", avatar = :avatar";
    }

    // Завершаем запрос условием по ID
    $sql .= " WHERE id = :id";

    // Подготавливаем и выполняем запрос
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":name", $data['name']);
    $stmt->bindValue(':email', $data['email']);
    if ($avatarPath !== null) {
      $stmt->bindValue(':avatar', $avatarPath);
    }
    $stmt->bindValue(':id', $userID);
    $stmt->execute();

    // После обновления — редирект на страницу профиля
    header("Location: profile.php");
    exit;
  }
}
?>