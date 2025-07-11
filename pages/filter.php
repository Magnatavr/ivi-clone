<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Подключаем файл инициализации, где находятся настройки и подключение к БД
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

// Задаем константу, чтобы дать понять, что приложение запущено (может быть нужно для header/footer)
define('APP_STARTED', true);

// Получаем список жанров, годов, стран и типов фильмов из базы данных
$ganres = getAllGenres($pdo);
$years = getAllYears($pdo);
$countries = getAllCountries($pdo);
$filmTypes = getFilmTypes($pdo);

// Инициализируем массив для фильмов
$movies = [];

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Собираем выбранные пользователем опции
  $options = [
    'genre' => $_POST['genre'] ?? null,
    'year' => $_POST['year'] ?? null,
    'country_id' => $_POST['country_id'] ?? null,
    'film_type' => $_POST['film_type'] ?? null,
  ];
  // Получаем фильмы по выбранным параметрам
  $movies = getMoviesData($pdo, $options);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Фильтры</title>
  <!-- Подключаем стили -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/index.css" />
  <!-- Подключаем JS -->
  <script type="module" src="../assets/js/index.js" defer></script>
</head>

<body>
  <!-- Хедер -->
  <?php require_once '../templates/header.php' ?>

  <!-- Главный блок с формой фильтрации -->
  <main class="filter">
    <div class="filter__container container" style="text-align: center; padding: 40px 0">
      <h1 class="filter__title">Найди фильм по своему вкусу</h1>
      <!-- Форма фильтрации -->
      <form class="filter__form" id="filterForm" action="" method="post">

        <!-- Фильтр по жанру -->
        <select class="filter__select" name="genre">
          <option value="">Выбери жанр</option>
          <?php foreach ($ganres as $genre): ?>
            <option value="<?= $genre['name'] ?>"><?= htmlspecialchars($genre['name']) ?></option>
          <?php endforeach; ?>
        </select>

        <!-- Фильтр по году выпуска -->
        <select class="filter__select" name="year">
          <option value="">Год выпуска</option>
          <?php foreach ($years as $year): ?>
            <option value="<?= $year ?>"><?= htmlspecialchars($year) ?></option>
          <?php endforeach; ?>
        </select>

        <!-- Фильтр по стране -->
        <select name="country_id" class="filter__select">
          <option value="">Страна</option>
          <?php foreach ($countries as $country): ?>
            <option value="<?= $country['id'] ?>"><?= htmlspecialchars($country['name']) ?></option>
          <?php endforeach; ?>
        </select>

        <!-- Фильтр по типу фильма -->
        <select name="film_type" class="filter__select">
          <option value="">Тип</option>
          <?php foreach ($filmTypes as $type): ?> <!-- ← исправлено здесь -->
            <option value="<?= $type['film_type'] ?>">
              <?= htmlspecialchars($type['film_type']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <!-- Кнопка отправки формы -->
        <button type="submit" class="filter__button">Поиск</button>
      </form>
    </div>

    <!-- Секция с результатами поиска -->
    <section class="movies">
      <div class="movies__container">
        <h2 class="movies__title">Результаты поиска</h2>

        <?php if (!empty($movies)): ?>
          <div class="movies__list" id="resultsContainer">
            <!-- Вывод карточек фильмов -->
            <div class="movie__card-container">

              <?php foreach ($movies as $movie): ?>
                <div class="movie-card">
                  <a href="<?= BASE_URL ?>/pages/movie.php?id=<?= htmlspecialchars($movie['id']) ?>">
                    <img src="<?= htmlspecialchars($movie['image']) ?>" class="movie-card__image"
                      alt="<?= htmlspecialchars($movie['title']) ?>" />
                    <div class="movie-card__hover-info">
                      <span><?= htmlspecialchars($movie['year']) ?></span>
                      <span><?= htmlspecialchars($movie['avg_rating']) ?></span>
                      <span><?= htmlspecialchars($movie['genres']) ?></span>
                    </div>
                    <h3 class="movie-card__title"><?= htmlspecialchars($movie['title']) ?></h3>
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php else: ?>
          <!-- Сообщение, если фильмы не найдены -->
          <p style="text-align: center;">Ничего не найдено</p>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <!-- Футер -->
  <?php require_once '../templates/footer.php' ?>

</body>

</html>