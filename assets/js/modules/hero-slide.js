// Функция heroSlide отвечает за работу слайдера на главной странице (hero-секция)
export function heroSlide() {
  // Находим основной контейнер слайдера
  const slider = document.querySelector(".hero__slider");

  // Получаем все слайды внутри слайдера
  const slides = document.querySelectorAll(".hero__slide");

  // Кнопки переключения: вперёд и назад
  const nextBtn = document.querySelector(".hero__arrow--right");
  const prevBtn = document.querySelector(".hero__arrow--left");

  // Индекс текущего активного слайда
  let current = 0;

  // Функция, которая обновляет отображение слайдов
  function updateSlides() {
    slides.forEach((slide, index) => {
      // Добавляем класс "active" только текущему слайду, остальные скрываются
      slide.classList.toggle("active", index === current);
    });
  }

  // Обработчик клика по кнопке "вперёд"
  nextBtn.addEventListener("click", () => {
    // Переход к следующему слайду, с зацикливанием (если в конце — возвращаемся к первому)
    current = (current + 1) % slides.length;
    updateSlides();
  });

  // Обработчик клика по кнопке "назад"
  prevBtn.addEventListener("click", () => {
    // Переход к предыдущему слайду, с зацикливанием (если в начале — переходим к последнему)
    current = (current - 1 + slides.length) % slides.length;
    updateSlides();
  });

  // Инициализируем слайдер при загрузке страницы
  updateSlides();
}
