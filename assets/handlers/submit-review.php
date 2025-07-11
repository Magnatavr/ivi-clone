<?php
// Запускаем сессию, если она ещё не запущена
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Подключаем конфигурацию базы данных и файл с функцией проверки авторизации
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

// Проверяем, что пользователь авторизован
checkAuth();

// Получаем ID текущего пользователя из сессии
$userId = $_SESSION['user_id'];

// Массив для сбора ошибок валидации
$errors = [];

// Обрабатываем только POST-запросы — когда пользователь отправил форму
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $movieId = $_POST['movie_id'] ?? null;
    // Приводим рейтинг к целому числу, если не передан — 0
    $rating = (int) ($_POST['rating'] ?? 0);
    // Убираем лишние пробелы в комментарии
    $comment = trim($_POST['comment'] ?? '');
}

// Проверяем корректность данных: 
// 1) movieId должен быть передан (не пустой)
// 2) рейтинг от 1 до 10
// 3) комментарий не пустой
if (!$movieId || $rating < 1 || $rating > 10 || $comment === '') {
    // Если что-то не так — добавляем ошибку
    $errors[] = 'Неверные данные';
}

// Если ошибок нет — сохраняем отзыв в базу
if (empty($errors)) {
    $stmt = $pdo->prepare('
        INSERT INTO reviews (user_id, movie_id, text, rating, created_at) 
        VALUES (:user_id, :movie_id, :comment, :rating, NOW())
    ');
    $stmt->execute([
        ':user_id' => $userId,
        ':movie_id' => $movieId,
        ':rating' => $rating,
        ':comment' => $comment
    ]);

    // После успешной записи перенаправляем пользователя обратно на страницу фильма
    header("Location: ../../pages/movie.php?id=$movieId");
    exit;
} else {
    // Если есть ошибки, сохраняем их в сессию для отображения на странице с формой отзыва
    $_SESSION['errors'] = $errors;

    // Перенаправляем обратно на страницу формы оставления отзыва
    header("Location: ../../pages/review.php");
    exit();
}
?>