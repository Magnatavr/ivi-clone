<?php
// Функция для получения всех отзывов по конкретному фильму
// Принимает:
// - $pdo — объект PDO для подключения к базе данных
// - $movieId — ID фильма, для которого нужны отзывы
// Возвращает массив ассоциативных массивов с отзывами
function getReviews(PDO $pdo, $movieId): array {
    // SQL-запрос выбирает рейтинг, текст отзыва (псевдоним comment), дату создания отзыва и имя пользователя
    // Объединяем таблицы reviews и users, чтобы получить имя пользователя, оставившего отзыв
    // Фильтруем по movie_id
    // Сортируем отзывы по дате создания от новых к старым
    $sql = "SELECT r.rating, r.text AS comment, r.created_at, u.name 
            FROM reviews r
            JOIN users u ON r.user_id = u.id 
            WHERE r.movie_id = :movie_id
            ORDER BY r.created_at DESC";

    // Подготавливаем запрос для предотвращения SQL-инъекций
    $stmt = $pdo->prepare($sql);

    // Выполняем запрос с передачей параметра movie_id
    $stmt->execute([':movie_id' => $movieId]);

    // Возвращаем все найденные отзывы в виде массива ассоциативных массивов
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
