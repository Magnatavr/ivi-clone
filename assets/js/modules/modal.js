// Функция для настройки модального окна
// Параметры:
// triggerSelector - селектор кнопки/элемента, который открывает модалку
// modalSelector - селектор самого модального окна
// closeSelector - селектор кнопки или элемента, который закрывает модалку
export function setupModal(triggerSelector, modalSelector, closeSelector) {
  // Находим элементы по переданным селекторам
  const trigger = document.querySelector(triggerSelector);
  const modal = document.querySelector(modalSelector);
  const close = document.querySelector(closeSelector);

  // Если любой из элементов не найден, прекращаем работу функции
  if (!trigger || !modal || !close) return;

  // Обработчик клика по кнопке открытия модального окна
  trigger.addEventListener("click", () => {
    modal.classList.add("active");  // Добавляем класс "active" — модалка показывается
  });

  // Обработчик клика по кнопке закрытия модального окна
  close.addEventListener("click", () => {
    modal.classList.remove("active");  // Убираем класс "active" — модалка скрывается
  });

  // Обработчик клика вне модального окна (на затемнённую область)
  window.addEventListener("click", (e) => {
    if (e.target === modal) {         // Если клик именно по подложке (модальному фону)
      modal.classList.remove("active"); // Закрываем модалку
    }
  });
}
