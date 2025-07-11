<?php
// Функция для получения всех стран из базы данных
// Принимает объект PDO для работы с базой
// Возвращает массив ассоциативных массивов с id и названием страны
function getAllCountries(PDO $pdo): array {
    // Выполняем запрос, выбирающий id и name из таблицы countries,
    // сортируя результат по имени страны в алфавитном порядке
    $stmt = $pdo->query("SELECT id, name FROM countries ORDER BY name");
    
    // Возвращаем все найденные записи в виде массива ассоциативных массивов
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
