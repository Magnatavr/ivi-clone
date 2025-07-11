// Ключ доступа к API OMDb (Open Movie Database)
const API_KEY = "73c505a";

// Базовый URL для запросов к OMDb API
const BASE_URL = "https://www.omdbapi.com/";

// Асинхронная функция для получения списка фильмов по строке поиска
export async function fetchMovies(query) {
  // Отправляем GET-запрос к OMDb API с параметрами: API-ключ и поисковый запрос
  const response = await fetch(
    `${BASE_URL}?apikey=${API_KEY}&s=${encodeURIComponent(query)}`
  );

  // Если HTTP-ответ не успешен (например, 404 или 500) — выбрасываем исключение
  if (!response.ok) throw new Error("Ошибка при загрузке данных");

  // Преобразуем ответ в JSON-формат
  const data = await response.json();

  // Если OMDb API вернул ошибку (например, фильм не найден)
  if (data.Response === "False") {
    throw new Error(data.Error || "Не удалось загрузить фильмы");
  }

  // Возвращаем массив найденных фильмов
  return data.Search || [];
}
