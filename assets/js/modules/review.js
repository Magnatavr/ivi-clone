// Функция для настройки кнопки "Отмена" в форме отзыва
export function setupReviewCancelButton() {
  // Находим кнопку с классом review__cancel-btn
  const cancelBtn = document.querySelector(".review__cancel-btn");

  // Если кнопка существует на странице
  if (cancelBtn) {
    // Добавляем обработчик события клика
    cancelBtn.addEventListener("click", () => {
      // При клике возвращаем пользователя на предыдущую страницу истории браузера
      window.history.back();
    });
  }
}
