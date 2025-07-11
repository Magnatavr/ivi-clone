<?php
// Подключаем и инициализируем проект (конфиги, подключение к БД, функции)
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

// Чтобы header и footer работали корректно (если они зависят от APP_STARTED)
define('APP_STARTED', true);

// Получаем тип фильма из параметра URL (например: /pages/type.php?type=movie)
$filmType = $_GET['type'] ?? null;

// Если параметр не передан — делаем редирект на главную страницу
if (!$filmType) {
    header('Location: ' . BASE_URL . '/index.php');
    exit; // Обязательно выходим после редиректа
}

// Получаем фильмы указанного типа из базы данных
$moviesByType = getMoviesData($pdo, ['film_type' => $filmType]);

// Создаём заголовок страницы (например, 'Movie' → 'Movie')
$pageTitle = ucfirst($filmType);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle) ?> — IVI Клон</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/index.css" />
</head>

<body>

    <!-- Подключаем header-шаблон -->
    <?php require_once '../templates/header.php' ?>

    <section class="section">
        <div class="container type_container">

            <!-- Заголовок секции, например: Movie, Cartoon и т.д. -->
            <h1 class="section__title"><?= htmlspecialchars($pageTitle) ?></h1>

            <?php if (count($moviesByType) > 0): ?>
                <!-- Блок с карточками фильмов -->
                <div class="movies__type-block">
                    <?php foreach ($moviesByType as $movie): ?>
                        <div class="movie-card">
                            <a href="<?= BASE_URL ?>/pages/movie.php?id=<?= htmlspecialchars($movie['id']) ?>">
                                <img src="<?= BASE_URL . '/' . htmlspecialchars($movie['image']) ?>" class="movie-card__image"
                                    alt="<?= htmlspecialchars($movie['title']) ?>" />

                                <!-- Блок с информацией при наведении -->
                                <div class="movie-card__hover-info">
                                    <span><?= htmlspecialchars($movie['year']) ?></span>
                                    <span><?= htmlspecialchars($movie['avg_rating']) ?></span>
                                    <span><?= htmlspecialchars($movie['genres']) ?></span>
                                    <h3 class="movie-card__title"><?= htmlspecialchars($movie['title']) ?></h3>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Если нет фильмов этого типа -->
                <p>Фильмы данного типа не найдены.</p>
            <?php endif; ?>

        </div>
    </section>

    <!-- Подключаем footer-шаблон -->
    <?php require_once '../templates/footer.php' ?>

</body>

</html>