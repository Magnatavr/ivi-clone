// Экспортируемая функция setupCancelButton отвечает за обработку нажатия на кнопку "Отмена" в форме редактирования профиля
export function setupCancelButton() {
  // Получаем элемент кнопки отмены по классу
  const cancelButton = document.querySelector(".edit-profile__cancel-button");

  // Проверяем, существует ли кнопка на текущей странице
  if (cancelButton) {
    // Назначаем обработчик события "click"
    cancelButton.addEventListener("click", () => {
      // При нажатии на кнопку выполняется переход на страницу профиля
      window.location.href = "profile.php";
    });
  }
}
