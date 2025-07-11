<?php
// Функция для получения данных пользователя по его ID
// Принимает:
// - $pdo: объект PDO для работы с базой данных
// - $userID: идентификатор пользователя (целое число)
// Возвращает:
// - ассоциативный массив с полями name, email и avatar пользователя
function getUserData(PDO $pdo, int $userID): array
{
    // Подготавливаем SQL-запрос для выборки имени, email и аватара пользователя по его ID
    $stmt = $pdo->prepare('SELECT name, email, avatar FROM users WHERE id = ?');
    
    // Выполняем запрос, подставляя ID пользователя
    $stmt->execute([$userID]);
    
    // Получаем результат в виде ассоциативного массива (или false, если пользователь не найден)
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
