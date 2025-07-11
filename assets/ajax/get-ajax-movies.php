<?php
// Подключаем файлы конфигурации, БД и необходимые функции
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';


// Получаем параметр сортировки из GET-запроса, если не указан — сортируем по умолчанию по дате добавления (recent)
$sort = $_GET['sort'] ?? 'recent';

// Получаем текущую страницу из GET-параметра, минимум 1 (чтобы не было 0 или отрицательных страниц)
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

// Задаём количество фильмов на одной странице
$limit = 5;

// Получаем массив фильмов с учётом параметров сортировки, лимита и текущей страницы
$movies = getMoviesData($pdo, [
    'sort' => $sort,
    'limit' => $limit,
    'page' => $page
]);

// Получаем общее количество страниц для пагинации
$totalPages = getCountMovies($pdo, $limit);
?>

<div class="movie__card-container">
    <!-- Кнопка "назад" в пагинации, показывается только если текущая страница больше 1 -->
    <?php if ($page > 1): ?>
        <button class="pagination-btn" data-page="<?= $page - 1 ?>" data-sort="<?= $sort ?>">&#10094;</button>
    <?php endif; ?>

    <!-- Перебираем все фильмы из массива и выводим карточки -->
    <?php foreach ($movies as $movie): ?>
        <div class="movie-card">
            <!-- Ссылка на страницу фильма, id передаём через GET -->
            <a href="./pages/movie.php?id=<?= htmlspecialchars($movie['id']) ?>">
                <!-- Картинка фильма -->
                <img src="<?= htmlspecialchars($movie['image']) ?>" class="movie-card__image"
                    alt="<?= htmlspecialchars($movie['title']) ?>" />

                <!-- Информация при наведении: год, рейтинг, жанры и название -->
                <div class="movie-card__hover-info">
                    <span><?= htmlspecialchars($movie['year']) ?></span>
                    <span><?= htmlspecialchars($movie['avg_rating']) ?></span>
                    <span><?= htmlspecialchars($movie['genres']) ?></span>
                    <h3 class="movie-card__title"><?= htmlspecialchars($movie['title']) ?></h3>
                </div>
            </a>
        </div>
    <?php endforeach ?>

    <!-- Кнопка "вперёд" в пагинации, показывается только если текущая страница меньше максимальной -->
    <?php if ($page < $totalPages): ?>
        <button class="pagination-btn" data-page="<?= $page + 1 ?>" data-sort="<?= $sort ?>">&#10095;</button>
    <?php endif; ?>
</div>

<!-- Блок пагинации с информацией о текущей странице и общем числе страниц -->
<div class="pagination" data-total="<?= $totalPages ?>" data-sort="<?= $sort ?>" data-current="<?= $page ?>">
    <span>Страница <?= $page ?> из <?= $totalPages ?></span>
</div>