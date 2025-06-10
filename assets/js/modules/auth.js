export function toggleAuth() {
  const authLink = document.querySelectorAll(".auth__link");
  const loginForm = document.querySelector(".auth__form--login");
  const registerForm = document.querySelector(".auth__form--register");

  const url = new URL(window.location.href);
  const paramValue = url.searchParams.get("name");

  if (paramValue === "login") {
    loginForm.classList.remove("hidden");
    registerForm.classList.add("hidden");
  } else if (paramValue === "register") {
    loginForm.classList.add("hidden");
    registerForm.classList.remove("hidden");
  }

  authLink.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      loginForm.classList.toggle("hidden");
      registerForm.classList.toggle("hidden");
    });
  });
}
