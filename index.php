<?php
// проверяем зарегистрирован ли пользователь 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Подключаем файлы конфигурации, БД и необходимые функции
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

//что бы хедер и футтер заработал передаем константу
define('APP_STARTED', true);
// для ajax
define('ALLOW_ACCESS', true);

// вызываем фунцию которая даст нам данные для главного борда 
$getHeroMovies = getMoviesData($pdo, ['sort' => 'popular', 'limit' => 6]);


?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>IVI Клон</title>
  <link rel="stylesheet" href="assets/css/index.css" />
  <script type="module" src="/assets/js/index.js" defer></script>
</head>

<body>
  <!-- передаем Хедер -->
  <?php require_once './templates/header.php' ?>

  <section class="hero ">
    <div class="hero__container ">
      <button class="hero__arrow hero__arrow--left">&#10094;</button>
      <div class="hero__viewport">
        <div class="hero__slider">
          <!-- проходимся по данным которые получили выше для главного борда -->
          <?php foreach ($getHeroMovies as $heroMovie): ?>
            <div class="hero__slide active">

              <?php
              // ставлю затычку в случае отсутсвия картинки
              $imagePath = $heroMovie['image'];
              if (!empty($imagePath) && file_exists($imagePath) && is_file($imagePath)) {
                $finelImage = htmlspecialchars($heroMovie['image']);
              } else {
                $finelImage = './assets/img/board/shrek.webp';
              }
              ?>
              <img src="<?= $finelImage ?>" alt="Фильм" class="hero__image" />
              <div class="hero__content">
                <h1 class="hero__title"><?= htmlspecialchars($heroMovie['title']) ?></h1>
                <p class="hero__description"><?= htmlspecialchars($heroMovie['description']) ?></p>
                <a href="./pages/movie.php?id=<?= htmlspecialchars($heroMovie['id']) ?>" class="hero__button">Смотреть</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <button class="hero__arrow hero__arrow--right">&#10095;</button>
    </div>
  </section>


  <!-- Секции фильмов -->


  <section class="movies container" data-sort="recent">
    <div class="movies__container">
      <h2 class="movies__title">Новинки</h2>
      <div class="movies__list" id="recent-list">
        <!-- Контент будет загружен AJAX'ом тоесть отображаться через джаваскрипт -->
      </div>
    </div>
  </section>

  <section class="movies container" data-sort="popular">
    <div class="movies__container">
      <h2 class="movies__title">Популярное</h2>
      <div class="movies__list" id="popular-list">
        <!-- Контент будет загружен AJAX'ом тоесть отображаться через джаваскрипт -->

      </div>
    </div>
  </section>

  <section class="movies container" data-sort="top">
    <div class="movies__container">
      <h2 class="movies__title">Топ 10 фильмов</h2>
      <div class="movies__list" id="top-list">
        <!-- Контент будет загружен AJAX'ом тоесть отображаться через джаваскрипт -->

      </div>
    </div>
  </section>


  <!-- передаем Футер -->
  <?php require_once './templates/footer.php' ?>

  <!-- Модальное окно поиска для запросов через апишку -->
  <div class="search-modal" id="searchModal">
    <div class="search-modal__content">
      <button class="search-modal__close" id="searchCloseBtn">&times;</button>
      <input type="text" id="searchInput" placeholder="Введите название фильма..." class="search-modal__input" />
      <div id="searchResults" class="search-modal__results"></div>
    </div>
  </div>
</body>

</html>