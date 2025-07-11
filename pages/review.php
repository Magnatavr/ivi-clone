<?php
// Если сессия ещё не запущена — запускаем её (нужно для работы $_SESSION)
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Подключаем главный файл инициализации (подключает конфигурацию, базу данных и общие функции)
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';

// Проверяем, авторизован ли пользователь (иначе перенаправление/выход в checkAuth())
checkAuth();

// Получаем ID пользователя из сессии (если есть)
$userId = $_SESSION['user_id'] ?? null;

// Защита от прямого доступа к файлу: если файл открыт напрямую (без define('MOVIE_PAGE')), выводим 403
if (!defined('MOVIE_PAGE')) {
  http_response_code(403); // Устанавливаем HTTP-код ответа "Доступ запрещён"
  exit('Доступ запрещён'); // Завершаем выполнение и выводим сообщение
}

// Проверка, что переменная $filmId установлена — она должна быть передана извне
if (!isset($filmId)) {
  // Если фильм не указан — перенаправляем на главную
  header("Location: ../index.php");
  exit;
}
?>


<section class="review">
  <div class="review__container">
    <h1 class="review__title">Оставить отзыв</h1>

    <!-- Форма отправки отзыва -->
    <form class="review__form" action="../assets/handlers/submit-review.php" method="POST">

      <!-- Выбор оценки -->
      <div class="review__group">
        <label for="rating" class="review__label">Оценка:</label>
        <select id="rating" name="rating" class="review__select" required>
          <!-- Предлагаем пользователю выбрать оценку от 10 до 1 -->
          <option value="10">10 – Шедевр</option>
          <option value="9">9 – Великолепно</option>
          <option value="8">8 – Очень хорошо</option>
          <option value="7">7 – Хорошо</option>
          <option value="6">6 – Неплохо</option>
          <option value="5">5 – Средне</option>
          <option value="4">4 – Ниже среднего</option>
          <option value="3">3 – Плохо</option>
          <option value="2">2 – Очень плохо</option>
          <option value="1">1 – Ужасно</option>
        </select>
      </div>

      <!-- Поле для комментария -->
      <div class="review__group">
        <label for="comment" class="review__label">Комментарий:</label>
        <textarea id="comment" name="comment" class="review__textarea" rows="6" placeholder="Напишите отзыв..."
          required></textarea>
      </div>

      <!-- Скрытое поле с ID фильма, к которому относится отзыв -->
      <input type="hidden" name="movie_id" value="<?= htmlspecialchars($filmId) ?>">

      <!-- Кнопки отправки и отмены -->
      <div class="review__buttons">
        <button type="submit" class="review__submit-btn">Отправить</button>
        <!-- Отмена — просто возвращаемся назад -->
        <button type="button" class="review__cancel-btn" onclick="window.history.back()">Отмена</button>
      </div>
    </form>
  </div>
</section>