<?php
// Функция для получения детальной информации о фильме по его ID
// Принимает:
// - $pdo — объект PDO для работы с базой данных
// - $id — идентификатор фильма (целое число)
// Возвращает:
// - ассоциативный массив с данными фильма или null, если фильм не найден
function getMovieById(PDO $pdo, int $id): array|null {
    // SQL-запрос с объединением нескольких таблиц для получения полной информации о фильме
    $sql = "SELECT 
                m.id,
                m.title,
                m.description,
                m.year,
                m.image,
                m.film_path,
                m.film_type,
                c.name AS country,
                ROUND(AVG(r.rating), 1) AS avg_rating,             -- средний рейтинг с округлением до 1 знака
                GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') AS genres  -- жанры фильма через запятую
            FROM movies m
            LEFT JOIN countries c ON m.country_id = c.id
            LEFT JOIN reviews r ON r.movie_id = m.id
            LEFT JOIN movie_genre mg ON mg.movie_id = m.id
            LEFT JOIN genres g ON mg.genre_id = g.id
            WHERE m.id = :id                                      -- фильтрация по ID фильма
            GROUP BY m.id";                                       // группируем по фильму для корректной агрегации рейтинга и жанров

    // Подготавливаем запрос, чтобы избежать SQL-инъекций
    $stmt = $pdo->prepare($sql);

    // Выполняем запрос, передавая параметр ID
    $stmt->execute([':id' => $id]);

    // Получаем результат как ассоциативный массив или false, если нет данных
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    // Возвращаем данные фильма или null, если фильм не найден
    return $movie !== false ? $movie : null;
}
?>
