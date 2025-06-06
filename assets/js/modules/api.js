const API_KEY = "73c505a";
const BASE_URL = "https://www.omdbapi.com/";

export async function fetchMovies(query) {
  const response = await fetch(
    `${BASE_URL}?apikey=${API_KEY}&s=${encodeURIComponent(query)}`
  );
  if (!response.ok) throw new Error("Ошибка при загрузке данных");
  const data = await response.json();
  return data.Search || [];
}
