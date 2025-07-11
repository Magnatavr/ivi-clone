<?php
// Функция для получения данных о фильмах с возможностью фильтрации, сортировки и пагинации
// Принимает:
// - $pdo — объект PDO для работы с БД
// - $options — массив с параметрами фильтрации, сортировки и пагинации
// Возвращает массив фильмов с необходимыми данными
function getMoviesData(PDO $pdo, array $options = []): array
{
    $where = [];   // Массив условий WHERE
    $params = [];  // Параметры для подготовленного запроса

    // Добавляем фильтр по жанру, если передан
    if (!empty($options['genre'])) {
        $where[] = 'g.name = :genre';
        $params[':genre'] = $options['genre'];
    }

    // Добавляем фильтр по типу фильма (movie, series и т.д.)
    if (!empty($options['film_type'])) {
        $where[] = 'm.film_type = :film_type';
        $params[':film_type'] = $options['film_type'];
    }

    // Фильтр по стране (по id страны)
    if (!empty($options['country_id'])) {
        $where[] = 'm.country_id = :country_id';
        $params[':country_id'] = $options['country_id'];
    }

    // Фильтр по году выпуска
    if (!empty($options['year'])) {
        $where[] = 'm.year = :year';
        $params[':year'] = $options['year'];
    }

    // Формируем часть запроса WHERE, соединяя условия через AND
    $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    // Определяем порядок сортировки в зависимости от параметра sort
    $orderBy = match ($options['sort'] ?? '') {
        'top' => 'avg_rating DESC',           // Сортировка по средней оценке по убыванию
        'recent' => 'm.created_at DESC',      // Сортировка по дате создания по убыванию (свежие)
        'popular' => 'avg_rating DESC',       // Популярные - тоже по средней оценке (можно изменить при необходимости)
        default => 'm.created_at DESC',       // По умолчанию сортируем по дате создания (свежие)
    };

    // Лимит записей на страницу (по умолчанию 20)
    $limit = $options['limit'] ?? 20;

    // Номер текущей страницы (по умолчанию 1)
    $page = $options['page'] ?? 1;

    // Вычисляем смещение для SQL OFFSET
    $offset = ($page - 1) * $limit;

    // Основной SQL-запрос с джойнами по связанным таблицам
    $sql = "SELECT 
        m.id,
        m.title,
        m.description,
        m.image,
        m.year,
        m.film_type,
        c.name AS country,
        ROUND(AVG(r.rating), 1) AS avg_rating, -- средний рейтинг с округлением до 1 знака после запятой
        GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') AS genres -- объединяем жанры через запятую
    FROM movies m
    LEFT JOIN countries c ON m.country_id = c.id
    LEFT JOIN reviews r ON r.movie_id = m.id
    LEFT JOIN movie_genre mg ON mg.movie_id = m.id
    LEFT JOIN genres g ON mg.genre_id = g.id
    $whereClause
    GROUP BY m.id
    ORDER BY $orderBy
    LIMIT $limit OFFSET $offset
    ";

    // Подготавливаем запрос
    $stmt = $pdo->prepare($sql);

    // Выполняем запрос с параметрами фильтрации
    $stmt->execute($params);

    // Возвращаем результат — массив фильмов с данными
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>