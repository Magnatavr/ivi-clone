// js/search.js
import { fetchMovies } from "./api.js";

export function setupSearch(inputSelector, resultContainerSelector) {
  const input = document.querySelector(inputSelector);
  const resultsContainer = document.querySelector(resultContainerSelector);
  if (!input || !resultsContainer) return;

  input.addEventListener("input", async () => {
    const query = input.value.trim();
    if (!query) {
      resultsContainer.innerHTML = "";
      return;
    }

    try {
      const movies = await fetchMovies(query);
      resultsContainer.innerHTML = movies.map(renderMovieCard).join("");
    } catch (error) {
      console.error("Ошибка поиска:", error);
    }
  });
}

function renderMovieCard(details) {
  return `
        <div class="search-modal__result-item">
          <img src="${
            details.Poster !== "N/A"
              ? details.Poster
              : "https://via.placeholder.com/100x150?text=No+Image"
          }" alt="${details.Title}" class="search-modal__poster">
          <div class="search-modal__info">
            <h3>${details.Title}</h3>
            <p>Год: ${details.Year}</p>
            <p>Жанр: ${details.Genre}</p>
            <p>Рейтинг: ${details.imdbRating}</p>
          </div>
        </div>
      `;
}
