export function moviesFilter() {
  const form = document.getElementById("filterForm");
  const resultsContainer = document.getElementById("resultsContainer");
  if (!form || !resultsContainer) return; // ← защита

  const movies = [
    {
      title: "Звёздные Войны",
      genre: "action",
      year: "2023",
      image: "../assets/img/board/starwars.jpg",
    },
    {
      title: "Смех сквозь слёзы",
      genre: "comedy",
      year: "2024",
      image: "../assets/img/board/shrek.webp",
    },
    {
      title: "Тяжёлый выбор",
      genre: "drama",
      year: "2025",
      image: "../assets/img/board/drama.jpg",
    },
    {
      title: "Смешной экшн",
      genre: "action",
      year: "2024",
      image: "../assets/img/board/actioncomedy.jpg",
    },
  ];

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const genre = form.genre.value;
    const year = form.year.value;
    const filtered = movies.filter((movie) => {
      return movie.genre === genre && movie.year === year;
    });
    renderMovies(filtered);
  });
  function renderMovies(filteredMovies) {
    resultsContainer.innerHTML = "";

    if (filteredMovies.length === 0) {
      resultsContainer.innerHTML =
        '<p style="text-align:center;">Фильмы не найдены.</p>';
      return;
    }
    filteredMovies.forEach((movie) => {
      const card = document.createElement("div");
      card.className = "movie-card";

      card.innerHTML = `
      <img src="${movie.image}" alt="${movie.title}" class="movie-card__image" />
      <div class="movie-card__info">
        <h3 class="movie-card__title">${movie.title}</h3>
        <a href="./movie.html" class="movie-card__button">Смотреть</a>
      </div>
    `;

      resultsContainer.appendChild(card);
    });
  }
}
