// Экспортируемая функция toggleAuth отвечает за переключение между формами входа и регистрации
export function toggleAuth() {
  // Получаем все ссылки переключения между формами (например, "Войти / Зарегистрироваться")
  const authLink = document.querySelectorAll(".auth__link");

  // Получаем форму входа
  const loginForm = document.querySelector(".auth__form--login");

  // Получаем форму регистрации
  const registerForm = document.querySelector(".auth__form--register");

  // Получаем текущий URL страницы
  const url = new URL(window.location.href);

  // Извлекаем значение параметра "name" из строки запроса (например, ?name=login или ?name=register)
  const paramValue = url.searchParams.get("name");

  // Если в URL передан параметр "name=login" — показываем форму входа и скрываем регистрацию
  if (paramValue === "login") {
    loginForm.classList.remove("hidden");     // Показываем форму входа
    registerForm.classList.add("hidden");     // Скрываем форму регистрации
  } 
  // Если передан "name=register" — показываем форму регистрации и скрываем вход
  else if (paramValue === "register") {
    loginForm.classList.add("hidden");        // Скрываем форму входа
    registerForm.classList.remove("hidden");  // Показываем форму регистрации
  }

  // Назначаем обработчик клика на все элементы с классом .auth__link
  authLink.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault(); // Отменяем стандартное поведение ссылки (переход по href)

      // Переключаем видимость форм: показываем одну, скрываем другую
      loginForm.classList.toggle("hidden");
      registerForm.classList.toggle("hidden");
    });
  });
}
