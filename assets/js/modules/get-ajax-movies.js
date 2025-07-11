// Экспортируемая функция для получения и отображения фильмов по AJAX
export function getAjaxMovies() {
  // Находим все секции с фильмами, у которых есть класс "movies container"
  const sections = document.querySelectorAll(".movies.container");

  /// Загружаем данные при старте страницы
  sections.forEach((section) => {
    const sort = section.dataset.sort; // Получаем тип сортировки из data-атрибута
    loadMovies(section, 1, sort); // Загружаем первую страницу фильмов для каждой секции
  });

  // Добавляем глобальный обработчик клика на документ
  document.addEventListener("click", (e) => {
    // Проверяем, клик был по кнопке пагинации
    if (e.target.classList.contains("pagination-btn")) {
      const page = e.target.dataset.page; // Получаем номер страницы из data-атрибута
      const sort = e.target.dataset.sort; // Получаем тип сортировки
      const section = document.querySelector(
        `.movies.container[data-sort="${sort}"]`
      ); // Находим нужную секцию по сортировке

      loadMovies(section, page, sort); // Загружаем фильмы с указанной страницы
    }
  });

  // Функция для загрузки фильмов по AJAX
  function loadMovies(section, page, sort) {
    const list = section.querySelector(".movies__list"); // Контейнер, куда загружаются карточки фильмов

    // Показываем текст загрузки
    list.innerHTML = `загрузка ....`;

    // Делаем AJAX-запрос к серверу
    fetch(`/assets/ajax/get-ajax-movies.php?page=${page}&sort=${sort}`)
      .then((res) => res.text()) // Преобразуем ответ в HTML
      .then((html) => {
        list.innerHTML = html; // Вставляем HTML-контент внутрь контейнера

        // Добавляем плавную анимацию появления карточек фильмов
        list.querySelectorAll(".movie-card").forEach((card) => {
          setTimeout(() => card.classList.add("fade-in"), 50); // Добавляем класс с задержкой
        });
      })
      .catch(() => {
        // В случае ошибки — выводим сообщение
        list.innerHTML = "<p>Ошибка загрузки</p>";
      });
  }
}
