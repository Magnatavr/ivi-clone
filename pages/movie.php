<?php
// Запускаем сессию, если она ещё не запущена
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Подключаем конфигурацию, подключение к БД и необходимые функции
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

// Передаём константу, чтобы подключить форму отзывов 
define('MOVIE_PAGE', true);

// Передаём константу, чтобы подключаемые шаблоны (header, footer) работали корректно
define('APP_STARTED', true);

// Получаем ID фильма из GET-параметра
$filmId = $_GET['id'] ?? null;

// Если ID не передан или не является числом — выводим сообщение и прекращаем выполнение
if (!$filmId || !is_numeric($filmId)) {
  echo 'Фильм не найден';
  exit;
}

// Получаем данные фильма из базы по ID
$movie = getMovieById($pdo, (int) $filmId);

// Если фильм не найден — выводим сообщение и прекращаем выполнение
if (!$movie) {
  echo 'Фильм не найден';
  exit;
}

// Получаем отзывы для текущего фильма
$reviews = getReviews($pdo, $filmId);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($movie['title']) ?> — Просмотр</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/index.css" />
</head>

<body>
  <!-- Хедер сайта -->
  <?php require_once '../templates/header.php' ?>

  <!-- Основной контент фильма -->
  <main class="movie">
    <div class="movie__container container">
      <div class="movie__top">
        <!-- Постер -->
        <div class="movie__poster">
          <img src="<?= BASE_URL . '/' . htmlspecialchars($movie['image']) ?>"
            alt="<?= htmlspecialchars($movie['title']) ?> Poster" class="movie__poster-img" />
        </div>

        <!-- Информация о фильме -->
        <div class="movie__info">
          <h1 class="movie__title"><?= htmlspecialchars($movie['title']) ?></h1>
          <div class="movie__details">
            <span class="movie__year"><?= htmlspecialchars($movie['year']) ?></span>
            <span class="movie__genre"><?= htmlspecialchars($movie['genres']) ?></span>
            <span class="movie__duration">2h 1min</span> <!-- Здесь можно сделать динамически -->
          </div>
          <div class="movie__rating">⭐ <?= htmlspecialchars($movie['avg_rating']) ?> / 10</div>
          <p class="movie__description"><?= htmlspecialchars($movie['description']) ?></p>
          <button class="movie__watch-btn">Watch Now</button>
        </div>
      </div>

      <!-- Видео плеер -->
      <div class="movie__player">
        <div class="movie__player-placeholder">
          <?php if (!empty($movie['film_path'])): ?>
            <video class="movie_video" controls>
              <source src="<?= BASE_URL . '/uploads/' . htmlspecialchars($movie['film_path']) ?>" type="video/mp4" />
              Ваш браузер не поддерживает воспроизведение видео.
            </video>
          <?php else: ?>
            <!-- Заглушка, если видео нет -->
            <p>🔴 Video Player Placeholder</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>

  <!-- Секция отзывов -->
  <section class="reviews container">
    <?php if (isset($_SESSION['user_id'])): ?>
      <!-- Если пользователь авторизован — подключаем форму отзыва -->
      <?php require_once './review.php'; ?>
    <?php else: ?>
      <!-- Если пользователь не авторизован — просим войти -->
      <p class="review__login-paragraph">
        <a href="./auth.php?name=login" class="review__login-link">Войдите</a>, чтобы оставить отзыв.
      </p>
    <?php endif; ?>

    <!-- Отображение отзывов -->
    <h2>Отзывы</h2>
    <?php if (count($reviews) === 0): ?>
      <p>Пока нет отзывов. Будьте первым!</p>
    <?php else: ?>
      <?php foreach ($reviews as $review): ?>
        <div class="review-item">
          <strong><?= htmlspecialchars($review['name']) ?></strong>
          <span>Оценка: <?= (int) $review['rating'] ?>/10</span>
          <p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
          <small><?= date('d.m.Y H:i', strtotime($review['created_at'])) ?></small>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </section>

  <!-- Футер сайта -->
  <?php require_once '../templates/footer.php' ?>
</body>

</html>