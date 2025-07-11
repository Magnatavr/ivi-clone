// Импортируем функцию для запроса фильмов по названию
import { fetchMovies } from "./api.js";

// Функция для настройки поиска фильмов по вводу пользователя
// inputSelector — селектор поля ввода поиска
// resultContainerSelector — селектор контейнера для отображения результатов
export function setupSearch(inputSelector, resultContainerSelector) {
  // Получаем элементы из DOM
  const input = document.querySelector(inputSelector);
  const resultsContainer = document.querySelector(resultContainerSelector);

  // Если один из элементов не найден — прекращаем работу
  if (!input || !resultsContainer) return;

  // Добавляем слушатель ввода текста
  input.addEventListener("input", async () => {
    // Берём введённый запрос и обрезаем пробелы
    const query = input.value.trim();

    // Если запрос пустой, очищаем результаты и выходим
    if (!query) {
      resultsContainer.innerHTML = "";
      return;
    }

    try {
      // Выполняем асинхронный запрос к API для получения фильмов по запросу
      const movies = await fetchMovies(query);

      // Формируем HTML для каждого фильма и выводим в контейнер
      resultsContainer.innerHTML = movies.map(renderMovieCard).join("");
    } catch (error) {
      // Если что-то пошло не так — выводим ошибку в консоль
      console.error("Ошибка поиска:", error);
    }
  });
}

// Функция для генерации HTML карточки фильма по его данным
function renderMovieCard(details) {
  return `
    <div class="search-modal__result-item">
      <img src="${
        // Если постер доступен, показываем его, иначе - плейсхолдер
        details.Poster !== "N/A"
          ? details.Poster
          : "https://via.placeholder.com/100x150?text=No+Image"
      }" alt="${details.Title}" class="search-modal__poster">
      <div class="search-modal__info">
        <h3>${details.Title}</h3>
        <p>Год: ${details.Year}</p>
        <p>Жанр: ${details.Genre || "Неизвестен"}</p> <!-- на всякий случай добавил fallback -->
        <p>Рейтинг: ${details.imdbRating || "N/A"}</p>
      </div>
    </div>
  `;
}
