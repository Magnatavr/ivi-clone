<?php
// Функция для получения всех уникальных типов фильмов из таблицы movies
// Принимает объект PDO для подключения к базе данных
// Возвращает массив с уникальными значениями поля film_type
function getFilmTypes(PDO $pdo): array
{
    // Выполняем SQL-запрос, выбирающий только уникальные (DISTINCT) значения film_type из таблицы movies
    $stmt = $pdo->query("SELECT DISTINCT film_type FROM movies");

    // Возвращаем результат в виде массива ассоциативных массивов,
    // где каждый элемент содержит ключ 'film_type' с соответствующим значением
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
